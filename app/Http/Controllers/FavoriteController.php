<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(): View
    {
        $ads = auth()->user()
            ->favorites()
            ->where('status', Ad::STATUS_PUBLISHED)
            ->with(['user', 'mainPhoto'])
            ->latest('favorites.created_at')
            ->get();

        return view('favorites', compact('ads'));
    }

    public function toggle(Ad $ad): JsonResponse
    {
        abort_unless($ad->isPublished(), 404);

        $result = auth()->user()->favorites()->toggle($ad->id);
        $favorited = count($result['attached']) > 0;

        return response()->json([
            'favorited' => $favorited,
            'count' => $ad->favoritedBy()->count(),
        ]);
    }
}
