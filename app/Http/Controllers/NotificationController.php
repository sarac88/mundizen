<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function read(AppNotification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        if ($notification->read_at === null) {
            $notification->update(['read_at' => now()]);
        }

        return redirect()->to($notification->targetUrl());
    }

    public function readAll(Request $request): RedirectResponse
    {
        auth()->user()
            ->appNotifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back();
    }

    public function destroy(AppNotification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->delete();

        return redirect()->back();
    }
}
