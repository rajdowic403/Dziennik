<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Frekwencja;
use Illuminate\Http\Request;

class FrekwencjaController extends Controller
{
public function create(Lesson $lesson)
{
    $students = $lesson->classGroup->students;

    $frekwencje = $lesson->frekwencje->keyBy('student_id');

    return view('frekwencje.create', compact('lesson','students', 'frekwencje'));


}

public function store(Request $request, Lesson $lesson)
{
    $validated = $request->validate([
        'frekwencja' => 'required|array',
        'frekwencja.*.status' => 'required|in:obecny,nieobecny,spóźniony,usprawiedliwienie',
        'frekwencja.*.uwagi' => 'nullable|string',
    ]);
    foreach ($validated['frekwencja'] as $studentId => $data) {
        Frekwencja::updateOrCreate(
            [
                'lesson_id' => $lesson->id,
                'student_id' => $studentId,
            ],
            [
                'status' => $data['status'],
                'uwagi' => $data['uwagi'] ?? null,
            ]
        );
    }
    return redirect()->back()->with('status', 'Obecność zapisana!');

}
}
