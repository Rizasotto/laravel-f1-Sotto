<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Artwork::where('status', 'active');

        // Category filter
        $category = $request->query('category');
        if ($category) {
            $query->where('category', $category);
        }

        // Price filter
        $priceRange = $request->query('price');
        if ($priceRange) {
            $ranges = [
                'under500' => [0, 500],
                '500to1500' => [500, 1500],
                '1500to3000' => [1500, 3000],
                'above3000' => [3000, 999999],
            ];
            if (isset($ranges[$priceRange])) {
                [$min, $max] = $ranges[$priceRange];
                $query->whereBetween('price', [$min, $max]);
            }
        }

        // Sort
        $sort = $request->query('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
        }

        $artworks = $query->paginate(12);

        return view('marketplace.index', compact('artworks', 'category', 'sort'));
    }

    public function show($id)
    {
        $artwork = Artwork::findOrFail($id);
        $artwork->increment('views');

        $relatedArtworks = Artwork::where('category', $artwork->category)
            ->where('id', '!=', $artwork->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('marketplace.show', compact('artwork', 'relatedArtworks'));
    }
}
