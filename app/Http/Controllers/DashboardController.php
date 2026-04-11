<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('moderator')) {
            return redirect()->route('moderator.dashboard');
        }

        return redirect()->route('student.dashboard');
    }

    public function moderatorIndex()
    {
        return view('dashboard.moderator');
    }

    public function studentIndex()
    {
        return view('dashboard.student');
    }
}