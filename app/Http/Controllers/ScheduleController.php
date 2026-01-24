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
}