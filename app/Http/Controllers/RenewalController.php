<?php

namespace App\Http\Controllers;

use App\Models\Renewal;
use Illuminate\Http\Request;

class RenewalController extends Controller
{
    /**
     * Display a listing of the renewals.
     */
    public function index()
    {
        return view('renewals.index');
    }

    /**
     * Show the form for creating a new renewal.
     */
    public function create()
    {
        return view('renewals.create');
    }

    /**
     * Show the form for editing the specified renewal.
     */
    public function edit(Renewal $renewal)
    {
        return view('renewals.edit', compact('renewal'));
    }
}
