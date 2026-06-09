<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Models\Ad;
use App\Models\AdPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdController extends Controller
{
    /**
     * @var array<string, string>
     */
    public const CATEGORY_MAP = [
        'manuales' => 'Manuales',
        'energeticas' => 'Energéticas',
        'cursos' => 'Cursos',
        'productos' => 'Productos',
    ];

    /**
     * @var array<string, string>
     */
    public const MODE_MAP = [
        'presencial' => 'Presencial',
        'online' => 'Online',
        'domicilio' => 'A domicilio',
    ];

    public function search(Request $request): View
    {
        $query = Ad::query()
            ->where('status', Ad::STATUS_PUBLISHED)
            ->with(['user', 'mainPhoto']);

        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($builder) use ($search): void {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            if (array_key_exists($category, self::CATEGORY_MAP)) {
                $query->where('category', $category);
            }
        }

        if ($city = $request->input('city')) {
            $query->where('city', $city);
        }

        if ($mode = $request->input('mode')) {
            if (array_key_exists($mode, self::MODE_MAP)) {
                $query->where('mode', $mode);
            }
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        match ($request->input('sort')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        $ads = $query->paginate(8)->withQueryString();

        $cities = ['Valencia', 'Barcelona', 'Madrid', 'Sevilla'];

        $favoriteIds = auth()->check()
            ? auth()->user()->favorites()->pluck('ads.id')->map(fn ($id) => (int) $id)->all()
            : [];

        return view('search', [
            'ads' => $ads,
            'cities' => $cities,
            'categoryMap' => self::CATEGORY_MAP,
            'modeMap' => self::MODE_MAP,
            'favoriteIds' => $favoriteIds,
        ]);
    }

    public function show(Ad $ad): View
    {
        abort_unless($ad->isPublished(), 404);

        $ad->load(['user', 'photos']);

        $related = Ad::query()
            ->where('status', Ad::STATUS_PUBLISHED)
            ->where('category', $ad->category)
            ->whereKeyNot($ad->id)
            ->with('mainPhoto')
            ->latest()
            ->take(3)
            ->get();

        $isFavorited = auth()->check() && $ad->isFavoritedBy(auth()->user());

        return view('listing', compact('ad', 'related', 'isFavorited'));
    }

    public function index(): View
    {
        $ads = auth()->user()
            ->ads()
            ->with('mainPhoto')
            ->latest()
            ->get();

        return view('my-ads', compact('ads'));
    }

    public function store(StoreAdRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $status = $request->isPublish() ? Ad::STATUS_PUBLISHED : Ad::STATUS_DRAFT;

        $ad = DB::transaction(function () use ($request, $validated, $status): Ad {
            $ad = auth()->user()->ads()->create([
                'category' => $validated['category'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'certifications' => $validated['certifications'] ?? null,
                'mode' => $validated['mode'] ?? null,
                'city' => $validated['city'] ?? null,
                'address' => $validated['address'] ?? null,
                'availability' => $validated['availability'] ?? null,
                'price_unit' => $validated['price_unit'] ?? null,
                'price' => $validated['price'] ?? null,
                'duration' => $validated['duration'] ?? null,
                'status' => $status,
                'terms_accepted' => $request->boolean('terms'),
            ]);

            $this->attachPhotos($ad, $request);

            return $ad;
        });

        $message = $ad->isPublished()
            ? '¡Anuncio publicado! Ya aparece en tu panel.'
            : 'Borrador guardado. Puedes continuar editándolo cuando quieras.';

        return redirect()
            ->route('my-ads')
            ->with('status', $message);
    }

    public function edit(Ad $ad): View
    {
        $this->authorizeOwner($ad);

        $ad->load('photos');

        return view('post-ad', compact('ad'));
    }

    public function update(StoreAdRequest $request, Ad $ad): RedirectResponse
    {
        $this->authorizeOwner($ad);

        $validated = $request->validated();
        $status = $request->isPublish() ? Ad::STATUS_PUBLISHED : Ad::STATUS_DRAFT;

        DB::transaction(function () use ($request, $validated, $status, $ad): void {
            $ad->update([
                'category' => $validated['category'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'certifications' => $validated['certifications'] ?? null,
                'mode' => $validated['mode'] ?? null,
                'city' => $validated['city'] ?? null,
                'address' => $validated['address'] ?? null,
                'availability' => $validated['availability'] ?? null,
                'price_unit' => $validated['price_unit'] ?? null,
                'price' => $validated['price'] ?? null,
                'duration' => $validated['duration'] ?? null,
                'status' => $status,
                'terms_accepted' => $request->boolean('terms') || $ad->terms_accepted,
            ]);

            $this->attachPhotos($ad, $request);
        });

        $message = $status === Ad::STATUS_PUBLISHED
            ? '¡Anuncio actualizado y publicado!'
            : 'Borrador actualizado. Puedes continuar editándolo cuando quieras.';

        return redirect()
            ->route('my-ads')
            ->with('status', $message);
    }

    public function toggleStatus(Request $request, Ad $ad): JsonResponse|RedirectResponse
    {
        $this->authorizeOwner($ad);

        $ad->update([
            'status' => $ad->isPublished() ? Ad::STATUS_DRAFT : Ad::STATUS_PUBLISHED,
        ]);

        $message = $ad->isPublished()
            ? '¡Anuncio publicado! Ya está visible para todos.'
            : 'Anuncio pausado. Ahora está guardado como borrador.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok' => true,
                'status' => $ad->status,
                'label' => $ad->statusLabel(),
                'message' => $message,
            ]);
        }

        return redirect()
            ->route('my-ads')
            ->with('status', $message);
    }

    public function destroy(Request $request, Ad $ad): JsonResponse|RedirectResponse
    {
        $this->authorizeOwner($ad);

        $ad->load('photos');

        DB::transaction(function () use ($ad): void {
            foreach ($ad->photos as $photo) {
                Storage::disk('public')->delete($photo->path);
            }

            Storage::disk('public')->deleteDirectory("ads/{$ad->id}");
            $ad->delete();
        });

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['ok' => true]);
        }

        return redirect()
            ->route('my-ads')
            ->with('status', 'Anuncio eliminado.');
    }

    public function destroyPhoto(Ad $ad, AdPhoto $photo): JsonResponse
    {
        $this->authorizeOwner($ad);
        abort_unless($photo->ad_id === $ad->id, 404);

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        $remaining = 5 - $ad->photos()->count();

        return response()->json(['ok' => true, 'remaining_slots' => $remaining]);
    }

    private function authorizeOwner(Ad $ad): void
    {
        abort_unless($ad->user_id === auth()->id(), 403);
    }

    private function attachPhotos(Ad $ad, StoreAdRequest $request): void
    {
        if (! $request->hasFile('photos')) {
            return;
        }

        $nextOrder = (int) ($ad->photos()->max('sort_order') ?? -1) + 1;

        foreach (array_filter($request->file('photos', []) ?? []) as $photo) {

            $path = $photo->store("ads/{$ad->id}", 'public');

            $ad->photos()->create([
                'path' => $path,
                'sort_order' => $nextOrder,
            ]);

            $nextOrder++;
        }
    }
}
