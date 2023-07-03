<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
	public function index()
	{
		return response()->json(Notification::where('to', auth()->id())->with('sender')->orderBy('created_at', 'desc')->get());
	}

	public function markAsRead()
	{
		Notification::where('read', '=', false)->update(['read' => true]);
		$allNotifications = Notification::latest()->where('to', auth()->id())->with('sender')->get();

		return response()->json($allNotifications, 200);
	}
}
