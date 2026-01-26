<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    // DODAJ TO KONIECZNIE:
    protected $fillable = [
        'subject_id', 
        'teacher_id', 
        'class_group_id', 
        'start', 
        'end'
    ];

    public function subject() { return $this->belongsTo(Subject::class); }
    public function teacher() { return $this->belongsTo(User::class, 'teacher_id'); }
    public function classGroup() { return $this->belongsTo(ClassGroup::class); }
}