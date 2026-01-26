<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson; // <--- TEGO BRAKOWAŁO
use Illuminate\Http\Request; // <--- TEGO BRAKOWAŁO
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    public function index()
{
 
    return Lesson::with(['subject', 'teacher', 'classGroup'])->get();
}

    public function store(Request $request)
    {
        
        try {
            $data = $request->validate([
                'subject_id'     => 'required|exists:subjects,id',
                'teacher_id'     => 'required|exists:users,id',
                'class_group_id' => 'required|exists:class_groups,id',
                'start'          => 'required',
                'end'            => 'required',
            ]);

            $lesson = Lesson::create($data);

            return response()->json($lesson, 201);
        } catch (\Exception $e) {
            Log::error("Błąd zapisu lekcji: " . $e->getMessage());
            return response()->json(['error' => 'Serwer nie mógł zapisać lekcji'], 500);
        }
    }
}