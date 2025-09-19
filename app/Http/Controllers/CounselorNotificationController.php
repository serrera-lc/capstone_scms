<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class CounselorNotificationController extends Controller
{
    public function index()
    {
        // Fetch notifications for logged-in counselor
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('counselor_notifications', compact('notifications'));
    }
}
