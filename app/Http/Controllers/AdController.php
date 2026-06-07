<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Models\Ad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdController extends Controller
{
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
