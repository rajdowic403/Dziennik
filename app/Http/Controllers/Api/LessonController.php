<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson; // <--- TEGO BRAKOWAŁO
use Illuminate\Http\Request; // <--- TEGO BRAKOWAŁO
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    public function index(Request $request)
{
 
   $user = $request->user();
        $query = Lesson::with(['subject', 'teacher', 'classGroup']);

        if ($user) {
            if ($user->hasRole('student')) {
                $query->where('class_group_id', $user->class_group_id);
            } elseif ($user->hasRole('teacher')) {
                $query->where('teacher_id', $user->id);
            } elseif ($user->hasRole('admin')) {
                if ($request->has('group_id') && $request->group_id !== '') {
                    $query->where('class_group_id', $request->group_id);
                }
            }
        } 
        else {
            if ($request->has('group_id') && $request->group_id !== '') {
                $query->where('class_group_id', $request->group_id);
            }
        }

        return response()->json($query->get());
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