<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
	public function index()
	{
		return response()->json(Notification::where('to', auth()->user()->id)->with('sender')->orderBy('created_at', 'desc')->get());
	}

	public function markAsRead()
	{
		$notification = Notification::where('read', '=', false);

		$notification->update(['read' => true]);

		$allNotifications = Notification::latest()->where('to', auth()->user()->id)->with('sender')->get();

		return response()->json($allNotifications, 200);
	}

	public function unread()
	{
		return response()->json(Notification::where('to', '=', auth()->user()->id)->where('read', '=', false)->count());
	}
}
