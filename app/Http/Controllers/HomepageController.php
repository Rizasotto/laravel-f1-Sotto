<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $featuredArtworks = Artwork::where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('landing', compact('featuredArtworks'));
    }
}
