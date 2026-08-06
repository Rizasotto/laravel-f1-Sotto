<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function index()
    {
        $artworks = auth()->user()->artworks()->paginate(12);
        return view('artist.artworks.index', compact('artworks'));
    }

    public function create()
    {
        return view('artist.artworks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'stock' => 'required|integer|min:0',
        ]);

        if (!$request->file('image')) {
            return redirect()->back()->with('error', 'No image file received');
        }

        $imagePath = $request->file('image')->store('artworks', 'public');
        
        if (!$imagePath) {
            return redirect()->back()->with('error', 'Failed to upload image');
        }

        $artwork = auth()->user()->artworks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'image_path' => $imagePath,
            'stock' => $validated['stock'],
            'status' => 'active',
        ]);

        if ($artwork) {
            return redirect()->route('artist.artworks.index')->with('success', '✓ Artwork "' . $validated['title'] . '" uploaded successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to save artwork to database');
        }
    }

    public function edit(Artwork $artwork)
    {
        $this->authorize('update', $artwork);
        return view('artist.artworks.edit', compact('artwork'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        $this->authorize('update', $artwork);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        $artwork->update($validated);

        return redirect()->route('artist.dashboard')->with('success', 'Artwork updated successfully!');
    }

    public function destroy(Artwork $artwork)
    {
        $this->authorize('delete', $artwork);
        $artwork->delete();

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Artwork $artwork)
    {
        $this->authorize('update', $artwork);
        
        $artwork->status = $artwork->status === 'active' ? 'inactive' : 'active';
        $artwork->save();

        return response()->json(['success' => true, 'status' => $artwork->status]);
    }
}
