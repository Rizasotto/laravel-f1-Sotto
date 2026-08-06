@extends('layouts.app')

@section('title', 'Artist Dashboard')

@section('extra-styles')
<style>
    /* Dashboard Layout */
    .dashboard-wrapper {
        background: #f8f9fa;
        min-height: calc(100vh - 100px);
        padding: 30px 0;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .dashboard-header p {
        font-size: 14px;
        opacity: 0.9;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-left: 5px solid #667eea;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-value {
        font-size: 32px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Tabs */
    .tabs-container {
        margin-bottom: 30px;
    }

    .tabs-header {
        display: flex;
        gap: 10px;
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 0;
        overflow-x: auto;
    }

    .tab-button {
        padding: 15px 30px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: #666;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .tab-button.active {
        color: #667eea;
        border-bottom-color: #667eea;
    }

    .tab-button:hover {
        color: #667eea;
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Section Titles */
    .section-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    /* Forms */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
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
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .upload-artwork-form {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .file-upload-area {
        border: 2px dashed #667eea;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-area:hover {
        background: #f0f0f0;
        border-color: #764ba2;
    }

    .file-upload-area p {
        color: #666;
        margin: 10px 0;
    }

    /* Cards Grid */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
    }

    .card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 15px;
    }

    .card-title {
        font-weight: bold;
        font-size: 14px;
        color: #333;
        margin-bottom: 8px;
    }

    .card-price {
        font-size: 16px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 8px;
    }

    .card-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .card-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }

    .btn-small {
        flex: 1;
        padding: 8px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-small-primary {
        background: #667eea;
        color: white;
    }

    .btn-small-primary:hover {
        background: #764ba2;
    }

    .btn-small-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-small-danger:hover {
        background: #f5c6cb;
    }

    /* Tables */
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    table thead {
        background: #f8f9fa;
    }

    table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e0e0e0;
    }

    table td {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    table tr:hover {
        background: #f8f9fa;
    }

    /* Analytics */
    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .analytics-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .metric-name {
        color: #666;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .metric-value {
        font-size: 28px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 8px;
    }

    .metric-change {
        font-size: 13px;
        color: #10b981;
    }

    /* Messages List */
    .messages-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .message-item {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }

    .message-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .message-header {
        display: grid;
        grid-template-columns: 40px 1fr auto;
        gap: 15px;
        align-items: start;
        margin-bottom: 10px;
    }

    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #667eea;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .message-from {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .message-subject {
        color: #666;
        font-size: 13px;
        margin-top: 2px;
    }

    .message-time {
        color: #999;
        font-size: 12px;
    }

    .message-text {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
        margin: 10px 0;
    }

    .message-actions {
        display: flex;
        gap: 10px;
    }

    /* Buttons */
    .button-group {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 12px 24px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn-action:hover {
        background: #764ba2;
        transform: translateY(-2px);
    }

    .btn-action-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-action-secondary:hover {
        background: #f0f0f0;
    }

    /* Empty States */
    .empty-state {
        background: white;
        padding: 60px 40px;
        border-radius: 12px;
        text-align: center;
        color: #999;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .tabs-header {
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .cards-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        table {
            font-size: 12px;
        }

        table th, table td {
            padding: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-header">
        <h1>🎨 Studio Dashboard - {{ auth()->user()->name }}</h1>
        <p>Manage your artworks, sales, and grow your artistic business</p>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        <!-- Overview Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $totalArtworks ?? 0 }}</div>
                <div class="stat-label">Total Artworks</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $totalSales ?? 0 }}</div>
                <div class="stat-label">Total Sales</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">₱{{ number_format($totalRevenue ?? 0, 0) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $totalViews ?? 0 }}</div>
                <div class="stat-label">Total Views</div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="tabs-container">
            <div class="tabs-header">
                <button class="tab-button active" onclick="switchTab(event, 'inventory')">📦 Inventory</button>
                <button class="tab-button" onclick="switchTab(event, 'upload')">⬆️ Upload New</button>
                <button class="tab-button" onclick="switchTab(event, 'orders')">📋 Orders</button>
                <button class="tab-button" onclick="switchTab(event, 'promotions')">🎉 Promotions</button>
                <button class="tab-button" onclick="switchTab(event, 'profile')">👤 Profile</button>
                <button class="tab-button" onclick="switchTab(event, 'analytics')">📊 Analytics</button>
                <button class="tab-button" onclick="switchTab(event, 'messages')">💬 Messages</button>
                <button class="tab-button" onclick="switchTab(event, 'reviews')">⭐ Reviews</button>
                <button class="tab-button" onclick="switchTab(event, 'withdraw')">💰 Withdrawals</button>
            </div>
        </div>

        <!-- TAB 1: Inventory Management -->
        <div id="inventory" class="tab-content active">
            <div class="section-title">📦 Artwork Inventory</div>
            <div class="button-group">
                <button class="btn-action" onclick="document.getElementById('uploadForm').scrollIntoView({behavior: 'smooth'});">+ Upload New Artwork</button>
                <a href="{{ route('artist.artworks.index') }}" class="btn-action btn-action-secondary">View All Artworks</a>
            </div>

            @if($recentArtworks && $recentArtworks->count() > 0)
                <div class="cards-grid">
                    @foreach($recentArtworks as $artwork)
                    <div class="card">
                        <img src="{{ str_contains($artwork->image_path, 'http') ? $artwork->image_path : (str_contains($artwork->image_path, 'artworks/') ? asset('storage/' . $artwork->image_path) : asset('storage/artworks/' . $artwork->image_path)) }}" alt="{{ $artwork->title }}" class="card-image" onerror="this.src='https://picsum.photos/seed/{{ $artwork->id }}/400/300'">
                        <div class="card-body">
                            <div class="card-title">{{ $artwork->title }}</div>
                            <div class="card-price">₱{{ number_format($artwork->price, 0) }}</div>
                            <span class="card-status {{ $artwork->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ $artwork->status == 'active' ? 'Active' : 'Inactive' }}
                            </span>
                            <div style="font-size: 12px; color: #999; margin-top: 8px;">👁 {{ $artwork->views }} views</div>
                            <div class="card-actions">
                                <button class="btn-small btn-small-primary">Edit</button>
                                <button class="btn-small btn-small-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No artworks uploaded yet. Start by uploading your first masterpiece!</p>
                </div>
            @endif
        </div>

        <!-- TAB 2: Upload New Artwork -->
        <div id="upload" class="tab-content">
            <div class="section-title">⬆️ Upload New Artwork</div>
            <div class="upload-artwork-form" id="uploadForm">
                <form action="{{ route('artist.artworks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>📸 Artwork Image</label>
                        <div class="file-upload-area" onclick="document.getElementById('imageInput').click();">
                            <p>🖼️ Click to upload or drag and drop</p>
                            <p style="font-size: 12px;">PNG, JPG, GIF up to 5MB</p>
                        </div>
                        <input type="file" id="imageInput" name="image" accept=".jpg,.jpeg,.png,.gif" style="display: none;" onchange="previewImageUpload(this)">
                        <div id="imagePreview" style="margin-top: 15px; text-align: center;">
                            <img id="previewImg" style="max-width: 200px; max-height: 200px; display: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" required placeholder="e.g., Sunset Over Mountains">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" required>
                                <option value="">Select Category</option>
                                <option value="Digital">Digital</option>
                                <option value="Traditional">Traditional</option>
                                <option value="Photo">Photo</option>
                                <option value="Abstract">Abstract</option>
                                <option value="Sculpture">Sculpture</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Price (₱)</label>
                            <input type="number" name="price" required placeholder="0.00" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Stock Quantity</label>
                            <input type="number" name="stock" required placeholder="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" required placeholder="Tell collectors about your artwork..."></textarea>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn-action">📤 Upload Artwork</button>
                        <button type="reset" class="btn-action btn-action-secondary">Clear Form</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- TAB 3: Orders & Sales -->
        <div id="orders" class="tab-content">
            <div class="section-title">📋 Recent Orders</div>
            
            @if($recentOrders && $recentOrders->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Artwork</th>
                                <th>Buyer</th>
                                <th>Order Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $orderItem)
                            <tr>
                                <td>{{ $orderItem->artwork->title ?? 'Unknown' }}</td>
                                <td>{{ $orderItem->order->buyer->name ?? 'Unknown' }}</td>
                                <td>{{ $orderItem->created_at->format('M d, Y') }}</td>
                                <td>₱{{ number_format($orderItem->subtotal, 2) }}</td>
                                <td><span class="card-status status-active">Completed</span></td>
                                <td><a href="{{ route('order.show', $orderItem->order) }}" class="btn-small btn-small-primary">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No orders yet. Start selling by uploading artworks!</p>
                </div>
            @endif
        </div>

        <!-- TAB 4: Promotions & Discounts -->
        <div id="promotions" class="tab-content">
            <div class="section-title">🎉 Promotions & Discounts</div>
            <div class="button-group">
                <button class="btn-action">+ Create New Promotion</button>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
                <div class="card" style="padding: 20px;">
                    <div style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Flash Sale</div>
                    <p style="color: #666; margin-bottom: 15px;">Up to 30% off on selected artworks</p>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn-small btn-small-primary">Edit</button>
                        <button class="btn-small btn-small-danger">Deactivate</button>
                    </div>
                </div>

                <div class="empty-state" style="padding: 30px; background: white; border: 2px dashed #ddd;">
                    <div class="empty-state-icon">🎯</div>
                    <p>Create promotions to increase sales and attract more buyers</p>
                    <button class="btn-action" style="margin-top: 15px;">+ Add Promotion</button>
                </div>
            </div>
        </div>

        <!-- TAB 5: Profile Settings -->
        <div id="profile" class="tab-content">
            <div class="section-title">👤 Artist Profile</div>
            <div class="upload-artwork-form">
                <form>
                    <div class="form-group">
                        <label>Studio Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" placeholder="Your Studio/Artist Name">
                    </div>

                    <div class="form-group">
                        <label>Bio/Description</label>
                        <textarea placeholder="Tell collectors about yourself and your artistic journey..."></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" placeholder="+63...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Specialization</label>
                        <select>
                            <option>Select your specialty</option>
                            <option>Painting</option>
                            <option>Digital Art</option>
                            <option>Photography</option>
                            <option>Sculpture</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-action">💾 Save Profile</button>
                </form>
            </div>
        </div>

        <!-- TAB 6: Analytics & Reports -->
        <div id="analytics" class="tab-content">
            <div class="section-title">📊 Sales Analytics</div>
            <div class="analytics-grid">
                <div class="analytics-card">
                    <div class="metric-name">Monthly Revenue</div>
                    <div class="metric-value">₱{{ number_format($totalRevenue ?? 0, 0) }}</div>
                    <div class="metric-change">↑ 12% from last month</div>
                </div>
                <div class="analytics-card">
                    <div class="metric-name">Average Order Value</div>
                    <div class="metric-value">₱3,500</div>
                    <div class="metric-change">↑ 5% from last month</div>
                </div>
                <div class="analytics-card">
                    <div class="metric-name">Conversion Rate</div>
                    <div class="metric-value">2.8%</div>
                    <div class="metric-change">↑ 0.5% from last month</div>
                </div>
                <div class="analytics-card">
                    <div class="metric-name">Avg Views/Artwork</div>
                    <div class="metric-value">145</div>
                    <div class="metric-change">↑ 23% from last month</div>
                </div>
            </div>

            <div style="margin-top: 30px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 15px;">📈 Sales Trend (Last 30 Days)</h3>
                <p style="color: #999; text-align: center; padding: 40px;">Chart visualization would go here</p>
            </div>
        </div>

        <!-- TAB 7: Messages & Communication -->
        <div id="messages" class="tab-content">
            <div class="section-title">💬 Buyer Messages</div>
            <div class="messages-list">
                <div class="message-item">
                    <div class="message-header">
                        <div class="message-avatar">JD</div>
                        <div>
                            <div class="message-from">John Doe</div>
                            <div class="message-subject">Question about "Modern Abstract"</div>
                        </div>
                        <div class="message-time">2 hours ago</div>
                    </div>
                    <div class="message-text">Hi! I'm interested in your artwork. Can you provide more details about the materials used?</div>
                    <div class="message-actions">
                        <button class="btn-small btn-small-primary">Reply</button>
                        <button class="btn-small btn-small-danger">Archive</button>
                    </div>
                </div>

                <div class="message-item">
                    <div class="message-header">
                        <div class="message-avatar">SM</div>
                        <div>
                            <div class="message-from">Sarah Miller</div>
                            <div class="message-subject">Order Inquiry</div>
                        </div>
                        <div class="message-time">Yesterday</div>
                    </div>
                    <div class="message-text">Can you do a custom commission? I'm looking for something similar to your digital work.</div>
                    <div class="message-actions">
                        <button class="btn-small btn-small-primary">Reply</button>
                        <button class="btn-small btn-small-danger">Archive</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 8: Reviews & Ratings -->
        <div id="reviews" class="tab-content">
            <div class="section-title">⭐ Customer Reviews</div>
            <div class="messages-list">
                <div class="message-item">
                    <div style="margin-bottom: 10px;">
                        <span style="color: #ffc107; font-size: 18px;">★★★★★</span>
                        <span style="color: #333; font-weight: bold; margin-left: 10px;">Excellent Quality</span>
                    </div>
                    <div style="color: #999; font-size: 13px; margin-bottom: 8px;">By <strong>James Wilson</strong> - 3 days ago</div>
                    <div style="color: #666; margin-bottom: 10px;">The artwork arrived in perfect condition. The colors are even more vibrant in person. Highly recommend!</div>
                </div>

                <div class="message-item">
                    <div style="margin-bottom: 10px;">
                        <span style="color: #ffc107; font-size: 18px;">★★★★☆</span>
                        <span style="color: #333; font-weight: bold; margin-left: 10px;">Great Work</span>
                    </div>
                    <div style="color: #999; font-size: 13px; margin-bottom: 8px;">By <strong>Emma Johnson</strong> - 1 week ago</div>
                    <div style="color: #666; margin-bottom: 10px;">Beautiful piece! The artist was very responsive to questions. Looking forward to purchasing more.</div>
                </div>
            </div>
        </div>

        <!-- TAB 9: Withdrawal/Payouts -->
        <div id="withdraw" class="tab-content">
            <div class="section-title">💰 Withdrawal Management</div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 30px;">
                <div class="analytics-card">
                    <div class="metric-name">Available Balance</div>
                    <div class="metric-value">₱{{ number_format($totalRevenue ?? 0, 0) }}</div>
                    <div class="metric-change">Ready to withdraw</div>
                </div>
                <div class="analytics-card">
                    <div class="metric-name">Pending Payouts</div>
                    <div class="metric-value">₱0</div>
                    <div class="metric-change">No pending withdrawals</div>
                </div>
                <div class="analytics-card">
                    <div class="metric-name">Total Withdrawn</div>
                    <div class="metric-value">₱0</div>
                    <div class="metric-change">All-time total</div>
                </div>
            </div>

            <div class="upload-artwork-form">
                <h3 style="margin-bottom: 20px;">Request Withdrawal</h3>
                <form>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Amount (₱)</label>
                            <input type="number" placeholder="Enter amount" min="1000">
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select>
                                <option>Select method</option>
                                <option>Bank Transfer</option>
                                <option>GCash</option>
                                <option>PayPal</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Account Details</label>
                        <input type="text" placeholder="Enter your account number/email">
                    </div>

                    <button type="submit" class="btn-action">💸 Request Withdrawal</button>
                </form>
            </div>

            <div style="margin-top: 30px;">
                <h3 style="margin-bottom: 20px;">Withdrawal History</h3>
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>No withdrawal history yet</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(event, tabName) {
    // Hide all tab contents
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.remove('active'));
    
    // Remove active class from all buttons
    const buttons = document.querySelectorAll('.tab-button');
    buttons.forEach(button => button.classList.remove('active'));
    
    // Show selected tab
    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}

// Preview image before upload
function previewImageUpload(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImg = document.getElementById('previewImg');
            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Handle file upload preview
document.getElementById('imageInput')?.addEventListener('change', function(e) {
    const filename = e.target.files[0]?.name || '';
    console.log('File selected:', filename);
});
</script>
@endsection
