@extends('layouts.app')

@section('title', 'Admin Panel')

@section('extra-styles')
<style>
    /* Admin Wrapper */
    .admin-wrapper {
        background: #f8f9fa;
        min-height: calc(100vh - 100px);
        padding: 30px 0;
    }

    .admin-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        margin-bottom: 30px;
        border-radius: 8px;
    }

    .admin-header h1 {
        font-size: 32px;
        margin-bottom: 5px;
    }

    /* Tabs */
    .admin-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        border-bottom: 2px solid #e0e0e0;
        overflow-x: auto;
    }

    .admin-tab-button {
        padding: 15px 25px;
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

    .admin-tab-button.active {
        color: #667eea;
        border-bottom-color: #667eea;
    }

    .admin-tab-button:hover {
        color: #667eea;
    }

    .admin-tab-content {
        display: none;
    }

    .admin-tab-content.active {
        display: block;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-left: 5px solid #667eea;
    }

    .stat-value {
        font-size: 32px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 13px;
        color: #666;
    }

    /* Tables */
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .table-header {
        padding: 20px;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h3 {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .table-actions {
        display: flex;
        gap: 10px;
    }

    .btn-add {
        padding: 8px 16px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .btn-add:hover {
        background: #764ba2;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    table thead {
        background: #f8f9fa;
    }

    table th {
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e0e0e0;
    }

    table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }

    table tr:hover {
        background: #f8f9fa;
    }

    .btn-small {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        transition: all 0.2s ease;
        margin-right: 5px;
    }

    .btn-edit {
        background: #667eea;
        color: white;
    }

    .btn-edit:hover {
        background: #764ba2;
    }

    .btn-delete {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-delete:hover {
        background: #f5c6cb;
    }

    .btn-approve {
        background: #d4edda;
        color: #155724;
    }

    .btn-approve:hover {
        background: #c3e6cb;
    }

    /* Forms */
    .form-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .form-section h3 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 13px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-submit {
        padding: 10px 20px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        background: #764ba2;
    }

    .btn-cancel {
        padding: 10px 20px;
        background: #f0f0f0;
        color: #333;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-cancel:hover {
        background: #e0e0e0;
    }

    /* Status Badge */
    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    /* Cards Grid */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .card-item {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .card-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .card-value {
        font-size: 24px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 10px;
    }

    .card-status {
        font-size: 12px;
        color: #666;
    }

    /* Chart Placeholder */
    .chart-placeholder {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        text-align: center;
        color: #999;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-tabs {
            flex-wrap: wrap;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        table {
            font-size: 11px;
        }

        table th, table td {
            padding: 8px 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-wrapper">
    <div class="admin-header">
        <h1>⚙️ Admin Dashboard</h1>
        <p>Manage platform users, artworks, categories, and promotions</p>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        <!-- Dashboard Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $totalUsers ?? 1250 }}</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $totalArtworks ?? 3847 }}</div>
                <div class="stat-label">Total Artworks</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">₱{{ number_format($totalRevenue ?? 2500000, 0) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $totalOrders ?? 12 }}</div>
                <div class="stat-label">Pending Approvals</div>
            </div>
        </div>

        <!-- Admin Tabs -->
        <div class="admin-tabs">
            <button class="admin-tab-button active" onclick="switchAdminTab(event, 'users')">👥 Users</button>
            <button class="admin-tab-button" onclick="switchAdminTab(event, 'artworks')">🎨 Artworks</button>
            <button class="admin-tab-button" onclick="switchAdminTab(event, 'categories')">📁 Categories</button>
            <button class="admin-tab-button" onclick="switchAdminTab(event, 'promotions')">🎉 Promotions</button>
            <button class="admin-tab-button" onclick="switchAdminTab(event, 'analytics')">📊 Analytics</button>
        </div>

        <!-- TAB 1: Users Management -->
        <div id="users" class="admin-tab-content active">
            <div class="table-container">
                <div class="table-header">
                    <h3>All Users</h3>
                    <div class="table-actions">
                        <button class="btn-add">+ Add User</button>
                        <input type="text" placeholder="Search users..." style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 12px;">
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sarah Chen</td>
                            <td>sarah@example.com</td>
                            <td>Artist</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>Jan 15, 2024</td>
                            <td>
                                <button class="btn-small btn-edit">Edit</button>
                                <button class="btn-small btn-delete">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td>Buyer</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>Feb 03, 2024</td>
                            <td>
                                <button class="btn-small btn-edit">Edit</button>
                                <button class="btn-small btn-delete">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Emma Wilson</td>
                            <td>emma@example.com</td>
                            <td>Artist</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>Mar 10, 2024</td>
                            <td>
                                <button class="btn-small btn-approve">Approve</button>
                                <button class="btn-small btn-delete">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Mike Johnson</td>
                            <td>mike@example.com</td>
                            <td>Buyer</td>
                            <td><span class="badge badge-danger">Suspended</span></td>
                            <td>Jan 22, 2024</td>
                            <td>
                                <button class="btn-small btn-edit">Edit</button>
                                <button class="btn-small btn-delete">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 2: Artworks Moderation -->
        <div id="artworks" class="admin-tab-content">
            <div class="table-container">
                <div class="table-header">
                    <h3>Artworks (Pending Moderation)</h3>
                    <div class="table-actions">
                        <select style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 12px;">
                            <option>All</option>
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Rejected</option>
                        </select>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Modern Abstract Dreams</td>
                            <td>Sarah Chen</td>
                            <td>Painting</td>
                            <td><span class="badge badge-info">Pending</span></td>
                            <td>Today</td>
                            <td>
                                <button class="btn-small btn-approve">Approve</button>
                                <button class="btn-small btn-delete">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Urban Landscape Vol. 2</td>
                            <td>Mike Photography</td>
                            <td>Photography</td>
                            <td><span class="badge badge-success">Approved</span></td>
                            <td>Yesterday</td>
                            <td>
                                <button class="btn-small btn-edit">View</button>
                                <button class="btn-small btn-delete">Remove</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Sunset Colors</td>
                            <td>Emma Art Studio</td>
                            <td>Digital Art</td>
                            <td><span class="badge badge-danger">Rejected</span></td>
                            <td>3 days ago</td>
                            <td>
                                <button class="btn-small btn-edit">View</button>
                                <button class="btn-small btn-delete">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 3: Categories Management -->
        <div id="categories" class="admin-tab-content">
            <div class="cards-grid">
                <div class="card-item">
                    <div style="font-size: 32px; margin-bottom: 10px;">🎨</div>
                    <div class="card-title">Painting</div>
                    <div class="card-value">245</div>
                    <div class="card-status">Active Artworks</div>
                    <div style="margin-top: 15px; display: flex; gap: 8px;">
                        <button class="btn-small btn-edit" style="flex: 1;">Edit</button>
                        <button class="btn-small btn-delete" style="flex: 1;">Delete</button>
                    </div>
                </div>
                <div class="card-item">
                    <div style="font-size: 32px; margin-bottom: 10px;">💻</div>
                    <div class="card-title">Digital Art</div>
                    <div class="card-value">189</div>
                    <div class="card-status">Active Artworks</div>
                    <div style="margin-top: 15px; display: flex; gap: 8px;">
                        <button class="btn-small btn-edit" style="flex: 1;">Edit</button>
                        <button class="btn-small btn-delete" style="flex: 1;">Delete</button>
                    </div>
                </div>
                <div class="card-item">
                    <div style="font-size: 32px; margin-bottom: 10px;">📷</div>
                    <div class="card-title">Photography</div>
                    <div class="card-value">312</div>
                    <div class="card-status">Active Artworks</div>
                    <div style="margin-top: 15px; display: flex; gap: 8px;">
                        <button class="btn-small btn-edit" style="flex: 1;">Edit</button>
                        <button class="btn-small btn-delete" style="flex: 1;">Delete</button>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>+ Add New Category</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" placeholder="e.g., Illustration">
                    </div>
                    <div class="form-group">
                        <label>Icon/Emoji</label>
                        <input type="text" placeholder="🎨">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea placeholder="Brief description..." rows="3"></textarea>
                </div>
                <div class="form-actions">
                    <button class="btn-submit">Add Category</button>
                    <button class="btn-cancel">Cancel</button>
                </div>
            </div>
        </div>

        <!-- TAB 4: Promotions & Deals -->
        <div id="promotions" class="admin-tab-content">
            <div class="table-container">
                <div class="table-header">
                    <h3>Active Promotions</h3>
                    <button class="btn-add">+ Create Promotion</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Summer Flash Sale</td>
                            <td>30%</td>
                            <td>Jun 01, 2024</td>
                            <td>Jun 30, 2024</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>
                                <button class="btn-small btn-edit">Edit</button>
                                <button class="btn-small btn-delete">End</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bundle Deal - 3 for 20%</td>
                            <td>20%</td>
                            <td>May 15, 2024</td>
                            <td>Jun 15, 2024</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>
                                <button class="btn-small btn-edit">Edit</button>
                                <button class="btn-small btn-delete">End</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 5: Analytics & Reports -->
        <div id="analytics" class="admin-tab-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">₱125,400</div>
                    <div class="stat-label">This Month Revenue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">523</div>
                    <div class="stat-label">New Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">1,847</div>
                    <div class="stat-label">Orders This Month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">2.4%</div>
                    <div class="stat-label">Growth Rate</div>
                </div>
            </div>

            <div class="chart-placeholder">
                <h3>📊 Revenue Chart (Last 30 Days)</h3>
                <p>Chart visualization would display here</p>
            </div>

            <div class="cards-grid" style="margin-top: 30px;">
                <div class="card-item">
                    <div class="card-title">Top Artist</div>
                    <div class="card-value">Sarah Chen</div>
                    <div class="card-status">242 artworks sold</div>
                </div>
                <div class="card-item">
                    <div class="card-title">Best Seller</div>
                    <div class="card-value">Modern Abstract</div>
                    <div class="card-status">₱45,200 revenue</div>
                </div>
                <div class="card-item">
                    <div class="card-title">Popular Category</div>
                    <div class="card-value">Photography</div>
                    <div class="card-status">1,234 sales</div>
                </div>
                <div class="card-item">
                    <div class="card-title">Avg Order Value</div>
                    <div class="card-value">₱3,850</div>
                    <div class="card-status">↑ 12% from last month</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchAdminTab(event, tabName) {
    // Hide all tab contents
    const contents = document.querySelectorAll('.admin-tab-content');
    contents.forEach(content => content.classList.remove('active'));
    
    // Remove active class from all buttons
    const buttons = document.querySelectorAll('.admin-tab-button');
    buttons.forEach(button => button.classList.remove('active'));
    
    // Show selected tab
    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}
</script>
@endsection
