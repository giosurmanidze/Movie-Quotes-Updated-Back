<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function index()
	{
		return response()->json(Notification::where('to', auth()->id())->with('sender')->orderBy('created_at', 'desc')->get());
	}

	public function markAsRead(Request $request)
	{
		if ($request->has('id')) {
			$notification = Notification::find($request->id);
			if (!$notification) {
				return response()->json(['message' => 'Notification not found'], 404);
			}
			$notification->read = true;
			$notification->save();
		} else {
			Notification::where('to', auth()->id())->update(['read' => true]);
		}
		$allNotifications = Notification::latest()
			->where('to', auth()->id())
			->with('sender')
			->get();

		return response()->json($allNotifications, 200);
	}
}
