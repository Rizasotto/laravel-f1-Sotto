@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #6C5CE7;
        --secondary: #FD79A8;
        --accent: #00CEC9;
        --bg-light: #F5F6FA;
        --text-dark: #2D3436;
        --text-light: #636E72;
    }
    
    body { background-color: var(--bg-light) !important; }
    
    .header-gradient {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        padding: 40px 20px;
        margin: -16px -20px 0 -20px;
        color: white;
        box-shadow: 0 4px 20px rgba(108, 92, 231, 0.15);
    }
    
    .header-gradient h1 { 
        font-size: 36px; 
        font-weight: 800; 
        margin: 0; 
        letter-spacing: -0.5px;
    }
    
    .header-gradient p {
        font-size: 14px;
        opacity: 0.95;
        margin: 8px 0 0 0;
        font-weight: 500;
    }
    
    .container-custom {
        background-color: var(--bg-light) !important;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .success-msg {
        background: rgba(0, 206, 201, 0.1) !important;
        border-left: 4px solid var(--accent) !important;
        color: var(--accent) !important;
        border-radius: 8px !important;
        font-weight: 500;
    }
    
    .artwork-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
    
    .artwork-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(45, 52, 54, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(108, 92, 231, 0.05);
    }
    
    .artwork-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(108, 92, 231, 0.15);
        border-color: rgba(108, 92, 231, 0.1);
    }
    
    .artwork-image {
        width: 100%;
        height: 220px;
        background: linear-gradient(135deg, #E8E8F0 0%, #F0E8F5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    
    .artwork-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .artwork-card:hover .artwork-image img {
        transform: scale(1.05);
    }
    
    .artwork-image-placeholder {
        width: 60px;
        height: 60px;
        opacity: 0.3;
        color: #999;
    }
    
    .artwork-content {
        padding: 24px;
    }
    
    .artwork-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        letter-spacing: -0.3px;
    }
    
    .artwork-artist {
        font-size: 14px;
        color: var(--text-light);
        margin-bottom: 12px;
        font-weight: 500;
    }
    
    .artwork-price {
        font-size: 22px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 16px;
        letter-spacing: -0.5px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        text-transform: uppercase;
    }
    
    .status-active {
        background: rgba(0, 206, 201, 0.15) !important;
        color: var(--accent) !important;
    }
    
    .status-inactive {
        background: rgba(99, 110, 114, 0.15) !important;
        color: var(--text-light) !important;
    }
    
    .button-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-action {
        border: none !important;
        padding: 12px 16px !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        cursor: pointer;
        transition: all 0.3s ease !important;
        width: 100% !important;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #5f4ed0 100%) !important;
        color: white !important;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(108, 92, 231, 0.3) !important;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #FF6B6B 0%, #FF5252 100%) !important;
        color: white !important;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 107, 107, 0.3) !important;
    }
    
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state p:first-child {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }
    
    .empty-state p:last-child {
        font-size: 14px;
        color: var(--text-light);
    }
    
    .pagination-wrapper {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }
</style>

<div class="header-gradient">
    <h1>Art Connect</h1>
    <p>Professional Artworks Management System</p>
</div>

<div class="container mx-auto px-4 py-8 container-custom">
    @if(session('success'))
    <div class="mb-6 p-4 success-msg rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="artwork-grid">
        @forelse($artworks as $artwork)
        <div class="artwork-card">
            <div class="artwork-image">
                @if($artwork->image_path)
                <img src="{{ str_contains($artwork->image_path, 'http') ? $artwork->image_path : (str_contains($artwork->image_path, 'artworks/') ? asset('storage/' . $artwork->image_path) : asset('storage/artworks/' . $artwork->image_path)) }}" alt="{{ $artwork->title }}" onerror="this.style.display='none'; this.parentElement.innerHTML += '<svg class=\"artwork-image-placeholder\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><rect x=\"3\" y=\"3\" width=\"18\" height=\"18\" rx=\"2\"></rect><circle cx=\"8.5\" cy=\"8.5\" r=\"1.5\"></circle><path d=\"M21 15l-5-5L5 21\"></path></svg>'">
                @else
                <svg class="artwork-image-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>
                @endif
            </div>
            
            <div class="artwork-content">
                <h3 class="artwork-title">{{ $artwork->title }}</h3>
                <p class="artwork-artist">by <strong>{{ $artwork->artist->name }}</strong></p>
                <p class="artwork-price">₱{{ number_format($artwork->price, 2) }}</p>
                
                <span class="status-badge {{ $artwork->status === 'active' ? 'status-active' : 'status-inactive' }}">
                    {{ ucfirst($artwork->status) }}
                </span>
                
                <div class="button-group">
                    <form action="{{ route('admin.toggle_artwork', $artwork->id) }}" method="POST" style="width: 100%; margin: 0;">
                        @csrf
                        <button type="submit" class="btn-action btn-primary">
                            {{ $artwork->status === 'active' ? '⊗ Deactivate' : '✓ Activate' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.delete_artwork', $artwork->id) }}" method="POST" style="width: 100%; margin: 0;" onsubmit="return confirm('Are you sure you want to delete this artwork?')">
                        @csrf
                        <button type="submit" class="btn-action btn-danger">
                            🗑 Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p>No Artworks Found</p>
            <p>Create your first artwork to get started</p>
        </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $artworks->links() }}
    </div>
</div>

@endsection
