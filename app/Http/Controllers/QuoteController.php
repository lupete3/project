<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    /**
     * Display a listing of the quotes.
     */
    public function index()
    {
        return view('quotes.index');
    }

    /**
     * Show the form for creating a new quote.
     */
    public function create()
    {
        return view('quotes.create');
    }

    /**
     * Display the specified quote.
     */
    public function show(Quote $quote)
    {
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified quote.
     */
    public function edit(Quote $quote)
    {
        return view('quotes.edit', compact('quote'));
    }

    /**
     * Download the quote as PDF.
     */
    public function download(Quote $quote)
    {
        $quote->load(['client', 'project', 'items']);
        $pdf = Pdf::loadView('quotes.pdf', compact('quote'));
        return $pdf->download('devis-' . $quote->quote_number . '.pdf');
    }
}
