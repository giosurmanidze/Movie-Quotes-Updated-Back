<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
	public function index()
	{
		return response()->json(Notification::where('to', auth()->user()->id)->with('sender')->orderBy('created_at', 'desc')->get());
	}
}
