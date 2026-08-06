@extends('layouts.app')

@section('title', 'Edit Artwork')

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
        flex: 1;
        padding: 12px;
        text-align: center;
    }

    .required::after {
        content: ' *';
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<h1>Edit Artwork</h1>

<div class="form-container">
    <form method="POST" action="{{ route('artwork.update', $artwork) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="required">Title</label>
            <input type="text" id="title" name="title" required value="{{ old('title', $artwork->title) }}">
            @error('title')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category" class="required">Category</label>
                <input type="text" id="category" name="category" required value="{{ old('category', $artwork->category) }}">
                @error('category')
                    <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="required">Price (₱)</label>
                <input type="number" id="price" name="price" required value="{{ old('price', $artwork->price) }}" step="0.01" min="0.01">
                @error('price')
                    <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="stock" class="required">Stock Quantity</label>
            <input type="number" id="stock" name="stock" required value="{{ old('stock', $artwork->stock) }}" min="1">
            @error('stock')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="required">Description</label>
            <textarea id="description" name="description" required>{{ old('description', $artwork->description) }}</textarea>
            @error('description')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Update Image (Optional)</label>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
            <div id="imagePreview" class="image-preview">
                <img src="{{ str_starts_with($artwork->image_path, 'http') ? $artwork->image_path : asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}">
            </div>
            @error('image')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('artist.artworks.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Artwork</button>
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
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
