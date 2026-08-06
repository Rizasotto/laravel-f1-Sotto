@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <style>
        .category-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
        }

        .category-card-modern {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e5e7eb !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .category-card-modern:hover {
            transform: scale(1.05) translateY(-4px);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.15) !important;
            border-color: #10b981 !important;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
        }

        .category-card-modern:hover .fw-600 {
            color: #10b981 !important;
        }

        .artwork-card {
            cursor: pointer;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .artwork-card img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .artwork-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
        }

        .artwork-card:hover img {
            transform: scale(1.08);
        }

        .artist-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .artist-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12) !important;
        }

        .btn-success {
            background-color: #10b981;
            border-color: #10b981;
            transition: all 0.2s ease;
        }

        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .hero-section {
            background: linear-gradient(90deg, #10b981, #059669);
            color: white;
            padding: 60px 0;
            transition: all 0.3s ease;
        }

        .fw-600 {
            font-weight: 600;
        }

        /* Responsive adjustments for category cards */
        @media (max-width: 768px) {
            .category-card-modern {
                min-height: 90px;
            }

            .category-card-modern div:first-child {
                font-size: 24px;
            }

            .category-card-modern h6 {
                font-size: 10px;
            }
        }

        @media (max-width: 576px) {
            .category-card-modern {
                min-height: 80px;
            }

            .category-card-modern div:first-child {
                font-size: 20px;
            }

            .category-card-modern h6 {
                font-size: 9px;
            }
        }
    </style>

    <!-- HERO SECTION -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-2" style="font-size: 36px;">Discover, Share, and Sell Art</h1>
                    <p class="mb-3" style="font-size: 16px; opacity: 0.95;">A Web-Based Platform for Artists</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('marketplace.index') }}" class="btn btn-warning px-4 py-2">
                            <i class="bi bi-search"></i> Browse Artworks
                        </a>
                        @auth
                            @if(auth()->user()->isArtist())
                            <a href="{{ route('artist.artworks.create') }}" class="btn btn-light px-4 py-2">
                                <i class="bi bi-cloud-upload"></i> Upload Artwork
                            </a>
                            @else
                            <a href="{{ route('switch.dashboard', 'artist') }}" class="btn btn-light px-4 py-2">
                                <i class="bi bi-star"></i> Become Artist
                            </a>
                            @endif
                        @else
                        <a href="{{ route('register') }}" class="btn btn-light px-4 py-2">
                            <i class="bi bi-cloud-upload"></i> Get Started
                        </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block" style="font-size: 100px;">🎨</div>
            </div>
        </div>
    </div>

    <div class="container my-5">

        <!-- Browse by Category Section -->
        <section class="py-5" style="background-color: transparent; margin: 0 -12px;">
            <div class="container">
                <!-- Section Header -->
                <div class="mb-4 text-center">
                    <h2 class="fw-bold mb-2" style="font-size: 28px; color: #1f2937;">Browse by Category</h2>
                    <p class="text-muted" style="font-size: 14px;">Explore artworks across different styles and mediums</p>
                </div>

                <!-- Category Grid -->
                <div class="row g-3">
                    @php
                        $categories = [
                            ['name' => 'Digital Art', 'icon' => '🎨', 'link' => 'Digital'],
                            ['name' => 'Traditional Art', 'icon' => '🖌️', 'link' => 'Traditional'],
                            ['name' => 'Photography', 'icon' => '📷', 'link' => 'Photo'],
                            ['name' => 'Abstract', 'icon' => '🧩', 'link' => 'Abstract'],
                            ['name' => 'Fan Art', 'icon' => '⭐', 'link' => 'Fan Art'],
                            ['name' => 'Sculptures', 'icon' => '🗿', 'link' => 'Sculpture'],
                        ];
                    @endphp

                    @foreach($categories as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('marketplace.index') }}?category={{ urlencode($category['link']) }}" class="text-decoration-none">
                            <div class="category-card-modern h-100 bg-white rounded-2 shadow-sm border border-light d-flex flex-column align-items-center justify-content-center p-2"
                                 style="min-height: 100px; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                                
                                <!-- Icon -->
                                <div class="mb-1" style="font-size: 28px; transition: transform 0.3s ease;">
                                    {{ $category['icon'] }}
                                </div>

                                <!-- Category Name -->
                                <h6 class="fw-600 text-dark text-center mb-0" style="font-size: 11px; line-height: 1.2; word-break: break-word;">
                                    {{ $category['name'] }}
                                </h6>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- FEATURED -->
        <h3 class="mt-5 mb-3 fw-bold">Featured Artworks</h3>
        @if($featuredArtworks->count() > 0)
        <div class="row g-3">
            @foreach($featuredArtworks->take(6) as $artwork)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('marketplace.show', $artwork->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm artwork-card border-0" style="overflow: hidden;">
                        @if($artwork->image_path)
                            <img src="{{ str_contains($artwork->image_path, 'http') ? $artwork->image_path : (str_contains($artwork->image_path, 'artworks/') ? asset('storage/' . $artwork->image_path) : asset('storage/artworks/' . $artwork->image_path)) }}" class="card-img-top" alt="{{ $artwork->title }}" style="height: 140px; object-fit: cover; width: 100%;" onerror="this.src='https://picsum.photos/400/300?random=999'">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px; font-size: 40px;">
                                🎨
                            </div>
                        @endif
                        <div class="card-body p-2">
                            <h6 class="card-title fw-bold" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 12px;">
                                {{ $artwork->title }}
                            </h6>
                            <small class="text-muted d-block mb-1" style="font-size: 10px;">{{ Str::limit($artwork->artist->name ?? 'Unknown', 15) }}</small>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success" style="font-size: 11px;">₱{{ number_format($artwork->price, 0) }}</span>
                                <span style="font-size: 12px;">❤️</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div style="font-size: 60px; opacity: 0.3; margin-bottom: 12px;">🎨</div>
            <h5 class="text-dark fw-bold mb-2">No artworks yet</h5>
            <p class="text-muted mb-3">Be the first to upload your masterpiece!</p>
            @auth
                @if(auth()->user()->isArtist())
                <a href="{{ route('artist.artworks.create') }}" class="btn btn-success">Upload Artwork</a>
                @endif
            @endauth
        </div>
        @endif

        <!-- TRENDING -->
        <h3 class="mt-5 mb-3 fw-bold">Trending Artworks 🔥</h3>
        @if($trendingArtworks->count() > 0)
        <div class="row g-3">
            @foreach($trendingArtworks->take(6) as $artwork)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('marketplace.show', $artwork->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm artwork-card border-0 position-relative" style="overflow: hidden;">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-1" style="font-size: 9px;">Hot 🔥</span>
                        @if($artwork->image_path)
                            <img src="{{ str_contains($artwork->image_path, 'http') ? $artwork->image_path : (str_contains($artwork->image_path, 'artworks/') ? asset('storage/' . $artwork->image_path) : asset('storage/artworks/' . $artwork->image_path)) }}" class="card-img-top" alt="{{ $artwork->title }}" style="height: 140px; object-fit: cover; width: 100%;" onerror="this.src='https://picsum.photos/400/300?random=999'">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px; font-size: 40px;">
                                🎨
                            </div>
                        @endif
                        <div class="card-body p-2">
                            <h6 class="card-title fw-bold" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 12px;">
                                {{ $artwork->title }}
                            </h6>
                            <small class="text-muted d-block mb-1" style="font-size: 10px;">{{ Str::limit($artwork->artist->name ?? 'Unknown', 15) }}</small>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success" style="font-size: 11px;">₱{{ number_format($artwork->price, 0) }}</span>
                                <span style="font-size: 12px;">❤️</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div style="font-size: 60px; opacity: 0.3; margin-bottom: 12px;">📊</div>
            <h5 class="text-dark fw-bold mb-2">No trending artworks</h5>
            <p class="text-muted">Check back soon!</p>
        </div>
        @endif

        <!-- TOP ARTISTS -->
        <h3 class="mt-5 mb-3 fw-bold">Top Artists</h3>
        @if($topArtists->count() > 0)
        <div class="row g-3">
            @foreach($topArtists->take(6) as $artist)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card text-center shadow-sm artist-card border-0 p-2">
                    <div style="width: 60px; height: 60px; margin: 0 auto 8px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: white;">
                        👤
                    </div>
                    <h6 class="card-title fw-bold" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 12px;">
                        {{ Str::limit($artist->name, 15) }}
                    </h6>
                    <small class="text-muted d-block" style="font-size: 10px;">{{ $artist->artworks_count ?? 0 }} Works</small>
                    <a href="#" class="btn btn-success btn-sm w-100 mt-1" style="font-size: 10px; padding: 4px 8px;">View</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div style="font-size: 60px; opacity: 0.3; margin-bottom: 12px;">👥</div>
            <h5 class="text-dark fw-bold mb-2">No artists yet</h5>
            <p class="text-muted">Be the first to join us!</p>
        </div>
        @endif

        <!-- CTA SECTION -->
        <div class="row mt-5 mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="bg-success text-white p-5 rounded text-center" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <h4 class="fw-bold mb-2">Ready to Share Your Creativity?</h4>
                    <p class="mb-3">Join us and start selling your artworks to a community of art lovers.</p>
                    @auth
                        @if(auth()->user()->isArtist())
                        <a href="{{ route('artist.artworks.create') }}" class="btn btn-light btn-lg">Start Uploading</a>
                        @else
                        <a href="{{ route('switch.dashboard', 'artist') }}" class="btn btn-light btn-lg">Become an Artist</a>
                        @endif
                    @else
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">Sign Up Now</a>
                    @endauth
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
