<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lesson; 

class ScheduleController extends Controller
{
    public function index()
    {
     
        $teachers = User::role('teacher')->get();
        
        return view('admin.schedule', compact('teachers'));
    }
    public function store(Request $request) {
    $validated = $request->validate([
        'subject_name' => 'required|string',
        'teacher_id' => 'required|exists:users,id',
        'start' => 'required|date',
        'end' => 'required|date',
    ]);

    \App\Models\Lesson::create($validated);
    return response()->json(['message' => 'Lekcja dodana']);
}
}