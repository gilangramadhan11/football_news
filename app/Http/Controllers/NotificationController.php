<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function show($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        // Tandai sudah dibaca
        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        // Redirect ke halaman tujuan
        return redirect($notification->data['url']);
    }

    public function readAll()
    {
        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }
}