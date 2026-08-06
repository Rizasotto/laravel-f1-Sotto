@extends('layouts.app')

@section('title', 'Create Artwork')

@section('extra-styles')
<style>
    .form-container {
        background: white;
        padding: 30px;
        border-radius: 4px;
        max-width: 600px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-family: inherit;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .image-preview {
        margin-top: 10px;
        border: 2px dashed #ddd;
        border-radius: 4px;
        padding: 20px;
        text-align: center;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 4px;
    }

    .image-preview.empty {
        color: #999;
        font-size: 14px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .form-actions .btn {
        padding: 12px 16px;
        text-align: center;
        flex: 1;
    }

    .form-actions .btn-primary {
        flex: 2;
    }

    .required::after {
        content: ' *';
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<h1>Create New Artwork</h1>

<!-- Error Messages -->
@if ($errors->any())
    <div style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
        <strong>❌ Upload Failed!</strong>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <span>{{ session('success') }}</span>
        <a href="{{ route('artist.artworks.index') }}" style="background: #155724; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: 600;">View All Artworks →</a>
    </div>
@endif

<!-- Recently Uploaded Artworks -->
@php
    $recentArtworks = auth()->user()->artworks()->orderByDesc('created_at')->limit(3)->get();
@endphp

@if($recentArtworks->count() > 0)
<div style="background: white; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
    <h2 style="margin-top: 0; margin-bottom: 15px; font-size: 18px;">📸 Recently Uploaded</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px;">
        @foreach($recentArtworks as $artwork)
        <div style="background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; text-align: center;">
            <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" style="width: 100%; height: 120px; object-fit: cover;" onerror="this.src='https://picsum.photos/400/300?random={{ rand(1, 9999) }}'">
            <div style="padding: 10px;">
                <div style="font-weight: 600; font-size: 12px; margin-bottom: 5px;">{{ Str::limit($artwork->title, 15) }}</div>
                <div style="color: #666; font-size: 11px; margin-bottom: 8px;">₱{{ number_format($artwork->price, 0) }}</div>
                <a href="{{ route('artist.artworks.edit', $artwork) }}" style="font-size: 11px; color: #10b981; text-decoration: none;">Edit</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="form-container">
    <form method="POST" action="{{ route('artist.artworks.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title" class="required">Title</label>
            <input type="text" id="title" name="title" required value="{{ old('title') }}" placeholder="Artwork title">
            @error('title')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category" class="required">Category</label>
                <input type="text" id="category" name="category" required value="{{ old('category') }}" placeholder="e.g., Painting, Sculpture">
                @error('category')
                    <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="required">Price (₱)</label>
                <input type="number" id="price" name="price" required value="{{ old('price') }}" step="0.01" min="0.01" placeholder="0.00">
                @error('price')
                    <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="stock" class="required">Stock Quantity</label>
            <input type="number" id="stock" name="stock" required value="{{ old('stock', 1) }}" min="1">
            @error('stock')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="required">Description</label>
            <textarea id="description" name="description" required placeholder="Describe your artwork...">{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image" class="required">Artwork Image</label>
            <div style="background: #f9f9f9; padding: 15px; border-radius: 4px; margin-bottom: 10px; font-size: 12px; color: #666;">
                ✓ Accept: JPEG, PNG, GIF<br>
                ✓ No file size limit
            </div>
            <input type="file" id="image" name="image" required accept="image/*" onchange="previewImage(this)">
            <div id="imagePreview" class="image-preview empty">
                <span>Upload an image (JPEG, PNG, GIF)</span>
            </div>
            @error('image')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" style="flex: 2;">✓ Upload Artwork</button>
            <a href="{{ route('artist.artworks.index') }}" class="btn btn-secondary">View My Artworks</a>
            <a href="{{ route('artist.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
            preview.classList.remove('empty');
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Clear form after page loads (in case of redirect with success message)
window.addEventListener('load', function() {
    const successMsg = document.querySelector('[style*="background: #d4edda"]');
    if (successMsg) {
        // Auto-scroll to top to see success message
        window.scrollTo(0, 0);
        // Clear the form for new upload
        document.querySelector('.form-container form').reset();
        document.getElementById('imagePreview').classList.add('empty');
        document.getElementById('imagePreview').innerHTML = '<span>Upload an image (JPEG, PNG, GIF)</span>';
    }
});
</script>
@endsection
