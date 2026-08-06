@extends('layouts.app')

@section('title', 'My Artworks')

@section('extra-styles')
<style>
    .artworks-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .artworks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .artwork-card {
        background: white;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .artwork-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .artwork-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background-color: #f0f0f0;
    }

    .artwork-info {
        padding: 15px;
    }

    .artwork-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .artwork-price {
        font-size: 16px;
        font-weight: bold;
        color: #10b981;
        margin-bottom: 8px;
    }

    .artwork-stats {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #999;
        margin-bottom: 12px;
    }

    .artwork-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .status-active {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-inactive {
        background-color: #f8d7da;
        color: #842029;
    }

    .artwork-actions {
        display: flex;
        gap: 8px;
    }

    .artwork-actions .btn {
        flex: 1;
        padding: 6px;
        font-size: 12px;
    }

    .empty-state {
        background: white;
        padding: 60px;
        border-radius: 4px;
        text-align: center;
    }

    .empty-state p {
        color: #999;
        margin-bottom: 20px;
    }

    .pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .pagination a, .pagination span {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
    }

    .pagination a:hover {
        background-color: #f0f0f0;
    }

    @media (max-width: 768px) {
        .artworks-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .artworks-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="artworks-header">
    <h1>My Artworks</h1>
    <a href="{{ route('artist.artworks.create') }}" class="btn btn-primary">+ Create New Artwork</a>
</div>

@if($artworks->count() > 0)
    <div class="artworks-grid">
        @foreach($artworks as $artwork)
        <div class="artwork-card">
            <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="artwork-image" onerror="this.src='https://picsum.photos/seed/{{ $artwork->id }}/400/300'">>
            
            <div class="artwork-info">
                <div class="artwork-title">{{ $artwork->title }}</div>
                <div class="artwork-price">₱{{ number_format($artwork->price, 2) }}</div>
                
                <div class="artwork-status status-{{ $artwork->status }}">
                    {{ strtoupper($artwork->status) }}
                </div>

                <div class="artwork-stats">
                    <span>👁 {{ $artwork->views }}</span>
                    <span>📦 {{ $artwork->stock }}</span>
                    <span>🛒 {{ $artwork->orderItems()->count() }}</span>
                </div>

                <div class="artwork-actions">
                    <a href="{{ route('artist.artworks.edit', $artwork) }}" class="btn btn-secondary">Edit</a>
                    <form method="POST" action="{{ route('artwork.destroy', $artwork) }}" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this artwork?')" style="width: 100%;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $artworks->links() }}
@else
    <div class="empty-state">
        <p style="font-size: 18px; margin-bottom: 20px;">🎨 No artworks yet</p>
        <p>Start creating your first artwork!</p>
        <a href="{{ route('artist.artworks.create') }}" class="btn btn-primary">Create Your First Artwork</a>
    </div>
@endif
@endsection
