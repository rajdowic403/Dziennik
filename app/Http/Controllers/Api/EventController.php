<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index() {
        // Pobieramy eventy zalogowanego usera
        return Event::where('user_id', Auth::id())->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string',
            'start' => 'required',
            'end' => 'required',
        ]);
        $userId = Auth::id() ?? 1;
        $event = Event::create([
            'title' => $data['title'],
            'start' => $data['start'],
            'end' => $data['end'],
            'user_id' => Auth::id(),
        ]);

        return response()->json($event);
    }
}