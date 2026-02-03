<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the team members.
     */
    public function index()
    {
        return view('team.index');
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create()
    {
        return view('team.create');
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit(User $user)
    {
        return view('team.edit', compact('user'));
    }
}
