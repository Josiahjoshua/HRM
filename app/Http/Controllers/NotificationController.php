<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $notifications = $user->unreadNotifications;

        $notifications = $notifications->map(function ($item) {
            $fromNow = $item->created_at->diffForHumans([
                'options' =>
                    Carbon::JUST_NOW |
                    Carbon::ONE_DAY_WORDS
            ]);
            $message = $item->data['message'];
            $url = $item->data['url']?? '#';

            $messageBody =
                '<button type="button" data-id="'.$item->id.'" data-href="'.
                $url .
                '" class="dropdown-item open_notification">' .
                $message .
                '
                <span class="float-right text-muted text-sm">' .
                $fromNow .
                '</span>
                </button> 
                <div class="dropdown-divider"></div>
                ';
            return $messageBody;
        });

        return response()->json([
            'total' => $notifications->count(),
            'notifications' => $notifications->implode(''),
        ]);
    }

    public function markAsRead(Request $request)
    {
        $user = auth()->user();

        $user->unreadNotifications->where('id', $request->id)->markAsRead();

        return response()->noContent();
    }

    public function markAllAsRead()
    {
        $user = auth()->user();

        $user->unreadNotifications->markAsRead();

        return response()->noContent();
    }
}
