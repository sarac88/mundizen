<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Models\Ad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $path = $photo->store("ads/{$ad->id}", 'public');

                    $ad->photos()->create([
                        'path' => $path,
                        'sort_order' => $index,
                    ]);
                }
            }

            return $ad;
        });

        $message = $ad->isPublished()
            ? '¡Anuncio publicado! Ya aparece en tu panel.'
            : 'Borrador guardado. Puedes continuar editándolo cuando quieras.';

        return redirect()
            ->route('my-ads')
            ->with('status', $message);
    }
}
