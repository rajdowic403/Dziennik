<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frekwencja extends Model
{
 protected $fillable = [
    'lesson_id',
    'student_id',
    'status',
    'uwagi'
 ];
 public function student(){
    return $this->belongsTo(User::class);
 }
 public function lesson(){
    return $this->belongsTo(Lesson::class);
 }
}
