<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>খরচ ব্যবস্থাপনা - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 0;
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s;
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar-header h3 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0 10px;
        }
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateX(5px);
        }
        .sidebar-menu a i {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 20px;
            transition: all 0.3s;
        }
        .top-navbar {
            background: white;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-header {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
            transition: all 0.3s;
        }
        .stat-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }
        .stat-card h6 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-card h3 {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .badge-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-active {
            background: #d4edda;
            color: #155724;
        }
        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .table thead th {
            border: none !important;
            color: white !important;
            font-weight: 600;
            padding: 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table tbody td {
            border: none;
            padding: 15px;
            vertical-align: middle;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
        }
        .table tbody tr:hover {
            background: #f9f9f9;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .action-buttons .btn {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 5px;
        }
        .btn-action {
            background: #667eea;
            color: white;
            border: none;
        }
        .btn-action:hover {
            background: #5568d3;
            color: white;
        }
        .btn-edit {
            background: #3498db;
            color: white;
            border: none;
        }
        .btn-edit:hover {
            background: #2980b9;
            color: white;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
        }
        .btn-delete:hover {
            background: #c82333;
            color: white;
        }
        
        /* Mobile Sidebar Toggle Button */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s;
        }
        .sidebar-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        .sidebar-toggle i {
            font-size: 20px;
        }
        
        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
            .sidebar {
                width: 0;
                padding: 0;
            }
            .main-content {
                margin-left: 0;
                padding: 10px;
                padding-top: 70px;
            }
            .top-navbar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    @include('admin.layouts.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Mobile Menu Toggle Button -->
        <button class="sidebar-toggle" onclick="toggleAdminSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Page Title with Bengali -->
        <div class="page-header mb-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="font-size: 28px; color: #667eea;">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div>
                    <h2 class="mb-1" style="color: #333;">খরচ ব্যবস্থাপনা</h2>
                    <p class="text-muted mb-0" style="font-size: 13px;">সেবার খরচ নির্ধারণ এবং পরিচালনা</p>
                </div>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCostModal">
                <i class="fas fa-plus"></i> নতুন খরচ যোগ করুন
            </button>
        </div>

        <!-- Alerts -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-circle"></i> ত্রুটি!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h3>{{ $totalCosts }}</h3>
                        <p class="mb-0">মোট খরচ সিস্টেম</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h3>{{ $totalActive }}</h3>
                        <p class="mb-0">সক্রিয় খরচ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h3>{{ $totalInactive }}</h3>
                        <p class="mb-0">নিষ্ক্রিয় খরচ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h3>৳ {{ number_format($totalAmount, 2) }}</h3>
                        <p class="mb-0">মোট খরচের সমষ্টি</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- First Row: 3 Columns -->
        <div class="row mb-4">
            <!-- Sign Copy Orders Type Cost Table -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-file-signature me-2"></i>সাইন কপি অর্ডার ({{ $signCopyCosts->count() }}টি)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="font-size: 13px;">
                                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                    <tr>
                                        <th style="color: white;">ID</th>
                                        <th style="color: white;">নাম</th>
                                        <th style="color: white;">খরচ</th>
                                        <th style="color: white;">ক্রিয়া</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($signCopyCosts as $cost)
                                        <tr>
                                            <td><strong>#{{ $cost->id }}</strong></td>
                                            <td><strong>{{ $cost->name_bn }}</strong></td>
                                            <td><strong style="color: #28a745;">৳ {{ number_format($cost->cost, 2) }}</strong></td>
                                            <td>
                                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editSignCopyModal{{ $cost->id }}" title="সম্পাদন করুন">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal for Sign Copy -->
                                        <div class="modal fade" id="editSignCopyModal{{ $cost->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>খরচ সম্পাদন করুন (সাইন কপি)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.cost.update', $cost->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="table_type" value="sign_copy">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-tag me-2"></i>খরচের নাম (বাংলা)</label>
                                                        <input type="text" class="form-control @error('name_bn') is-invalid @enderror" name="name_bn" 
                                                               value="{{ old('name_bn', $cost->name_bn) }}" required>
                                                        @error('name_bn')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-code me-2"></i>কোড (অপরিবর্তনীয়)</label>
                                                        <input type="text" class="form-control" name="code" 
                                                               value="{{ old('code', $cost->code) }}" disabled>
                                                        <small class="text-muted">কোড সম্পাদন করা যায় না</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-money-bill-wave me-2"></i>খরচ (টাকা)</label>
                                                        <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" name="cost" 
                                                               value="{{ old('cost', $cost->cost) }}" required>
                                                        @error('cost')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="is_active" 
                                                                   value="1" id="activeSignCopy{{ $cost->id }}" {{ $cost->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="activeSignCopy{{ $cost->id }}">
                                                                <i class="fas fa-toggle-on me-2"></i>সক্রিয় রাখুন
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                                                    <button type="submit" class="btn btn-primary" style="background: #667eea; border: none;">
                                                        <i class="fas fa-save me-2"></i>আপডেট করুন
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">
                                                <small>কোনো ডেটা নেই</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NID Types Cost Table -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-id-card me-2"></i>এনআইডি টাইপ ({{ $nidCosts->count() }}টি)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="font-size: 13px;">
                                <thead style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                    <tr>
                                        <th style="color: white;">ID</th>
                                        <th style="color: white;">নাম</th>
                                        <th style="color: white;">খরচ</th>
                                        <th style="color: white;">ক্রিয়া</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($nidCosts as $cost)
                                        <tr>
                                            <td><strong>#{{ $cost->id }}</strong></td>
                                            <td><strong>{{ $cost->name_bn }}</strong></td>
                                            <td><strong>{{ $cost->name_bn }}</strong></td>
                                            <td><strong style="color: #28a745;">৳ {{ number_format($cost->cost, 2) }}</strong></td>
                                            <td>
                                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editNidModal{{ $cost->id }}" title="সম্পাদন করুন">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal for NID -->
                                        <div class="modal fade" id="editNidModal{{ $cost->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>খরচ সম্পাদন করুন (এনআইডি)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.cost.update', $cost->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="table_type" value="nid">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-tag me-2"></i>খরচের নাম (বাংলা)</label>
                                                        <input type="text" class="form-control @error('name_bn') is-invalid @enderror" name="name_bn" 
                                                               value="{{ old('name_bn', $cost->name_bn) }}" required>
                                                        @error('name_bn')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-code me-2"></i>কোড (অপরিবর্তনীয়)</label>
                                                        <input type="text" class="form-control" name="code" 
                                                               value="{{ old('code', $cost->code) }}" disabled>
                                                        <small class="text-muted">কোড সম্পাদন করা যায় না</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-money-bill-wave me-2"></i>খরচ (টাকা)</label>
                                                        <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" name="cost" 
                                                               value="{{ old('cost', $cost->cost) }}" required>
                                                        @error('cost')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="is_active" 
                                                                   value="1" id="activeNid{{ $cost->id }}" {{ $cost->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="activeNid{{ $cost->id }}">
                                                                <i class="fas fa-toggle-on me-2"></i>সক্রিয় রাখুন
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                                                    <button type="submit" class="btn btn-primary" style="background: #f093fb; border: none;">
                                                        <i class="fas fa-save me-2"></i>আপডেট করুন
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">
                                                <small>কোনো ডেটা নেই</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passport Orders Type Cost Table -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-passport me-2"></i>পাসপোর্ট অর্ডার ({{ $passportCosts->count() }}টি)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="font-size: 13px;">
                                <thead style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                    <tr>
                                        <th style="color: white;">ID</th>
                                        <th style="color: white;">নাম</th>
                                        <th style="color: white;">খরচ</th>
                                        <th style="color: white;">ক্রিয়া</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($passportCosts as $cost)
                                        <tr>
                                            <td><strong>#{{ $cost->id }}</strong></td>
                                            <td><strong>{{ $cost->name_bn }}</strong></td>
                                            <td><strong style="color: #28a745;">৳ {{ number_format($cost->cost, 2) }}</strong></td>
                                            <td>
                                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editPassportModal{{ $cost->id }}" title="সম্পাদন করুন">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                    </tr>

                                    <!-- Edit Modal for Passport -->
                                    <div class="modal fade" id="editPassportModal{{ $cost->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>খরচ সম্পাদন করুন (পাসপোর্ট)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.cost.update', $cost->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="table_type" value="passport">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-tag me-2"></i>খরচের নাম (বাংলা)</label>
                                                        <input type="text" class="form-control @error('name_bn') is-invalid @enderror" name="name_bn" 
                                                               value="{{ old('name_bn', $cost->name_bn) }}" required>
                                                        @error('name_bn')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-code me-2"></i>কোড (অপরিবর্তনীয়)</label>
                                                        <input type="text" class="form-control" name="code" 
                                                               value="{{ old('code', $cost->code) }}" disabled>
                                                        <small class="text-muted">কোড সম্পাদন করা যায় না</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-money-bill-wave me-2"></i>খরচ (টাকা)</label>
                                                        <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" name="cost" 
                                                               value="{{ old('cost', $cost->cost) }}" required>
                                                        @error('cost')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="is_active" 
                                                                   value="1" id="activePassport{{ $cost->id }}" {{ $cost->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="activePassport{{ $cost->id }}">
                                                                <i class="fas fa-toggle-on me-2"></i>সক্রিয় রাখুন
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                                                    <button type="submit" class="btn btn-primary" style="background: #4facfe; border: none;">
                                                        <i class="fas fa-save me-2"></i>আপডেট করুন
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">
                                                <small>কোনো ডেটা নেই</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row: 3 Columns -->
        <div class="row">
            <!-- SIM Conversion Type Cost Table -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-sim-card me-2"></i>সিম কনভার্সন ({{ $simConversionCosts->count() }}টি)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="font-size: 13px;">
                                <thead style="background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%); color: white;">
                                    <tr>
                                        <th style="color: white;">ID</th>
                                        <th style="color: white;">নাম</th>
                                        <th style="color: white;">খরচ</th>
                                        <th style="color: white;">ক্রিয়া</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($simConversionCosts as $cost)
                                        <tr>
                                            <td><strong>#{{ $cost->id }}</strong></td>
                                            <td><strong>{{ $cost->name_bn }}</strong></td>
                                            <td><strong style="color: #28a745;">৳ {{ number_format($cost->cost, 2) }}</strong></td>
                                            <td>
                                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editSimConversionModal{{ $cost->id }}"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editSimConversionModal{{ $cost->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%); color: white;">
                                                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>খরচ সম্পাদন করুন (সিম কনভার্সন)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.cost.update', $cost->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="table_type" value="sim_conversion">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-tag me-2"></i>খরচের নাম (বাংলা)</label>
                                                        <input type="text" class="form-control" name="name_bn" value="{{ old('name_bn', $cost->name_bn) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-code me-2"></i>কোড (অপরিবর্তনীয়)</label>
                                                        <input type="text" class="form-control" value="{{ $cost->code }}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-money-bill-wave me-2"></i>খরচ (টাকা)</label>
                                                        <input type="number" step="0.01" class="form-control" name="cost" value="{{ old('cost', $cost->cost) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeSimConv{{ $cost->id }}" {{ $cost->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="activeSimConv{{ $cost->id }}"><i class="fas fa-toggle-on me-2"></i>সক্রিয় রাখুন</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                                                    <button type="submit" class="btn btn-primary" style="background: #FA8BFF; border: none;"><i class="fas fa-save me-2"></i>আপডেট করুন</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-3 text-muted"><small>কোনো ডেটা নেই</small></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SIM Network Orders Type Cost Table -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-network-wired me-2"></i>সিম নেটওয়ার্ক ({{ $simNetworkCosts->count() }}টি)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="font-size: 13px;">
                                <thead style="background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); color: white;">
                                    <tr>
                                        <th style="color: white;">ID</th>
                                        <th style="color: white;">নাম</th>
                                        <th style="color: white;">খরচ</th>
                                        <th style="color: white;">ক্রিয়া</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($simNetworkCosts as $cost)
                                        <tr>
                                            <td><strong>#{{ $cost->id }}</strong></td>
                                            <td><strong>{{ $cost->name_bn }}</strong></td>
                                            <td><strong style="color: #28a745;">৳ {{ number_format($cost->cost, 2) }}</strong></td>
                                            <td>
                                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editSimNetworkModal{{ $cost->id }}"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editSimNetworkModal{{ $cost->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); color: white;">
                                                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>খরচ সম্পাদন করুন (সিম নেটওয়ার্ক)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.cost.update', $cost->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="table_type" value="sim_network">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-tag me-2"></i>খরচের নাম (বাংলা)</label>
                                                        <input type="text" class="form-control" name="name_bn" value="{{ old('name_bn', $cost->name_bn) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-code me-2"></i>কোড (অপরিবর্তনীয়)</label>
                                                        <input type="text" class="form-control" value="{{ $cost->code }}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-money-bill-wave me-2"></i>খরচ (টাকা)</label>
                                                        <input type="number" step="0.01" class="form-control" name="cost" value="{{ old('cost', $cost->cost) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeSimNet{{ $cost->id }}" {{ $cost->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="activeSimNet{{ $cost->id }}"><i class="fas fa-toggle-on me-2"></i>সক্রিয় রাখুন</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                                                    <button type="submit" class="btn btn-primary" style="background: #2193b0; border: none;"><i class="fas fa-save me-2"></i>আপডেট করুন</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-3 text-muted"><small>কোনো ডেটা নেই</small></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIN Orders Type Cost Table -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-file-invoice me-2"></i>টিআইএন অর্ডার ({{ $tinCosts->count() }}টি)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="font-size: 13px;">
                                <thead style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); color: white;">
                                    <tr>
                                        <th style="color: white;">ID</th>
                                        <th style="color: white;">নাম</th>
                                        <th style="color: white;">খরচ</th>
                                        <th style="color: white;">ক্রিয়া</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tinCosts as $cost)
                                        <tr>
                                            <td><strong>#{{ $cost->id }}</strong></td>
                                            <td><strong>{{ $cost->name_bn }}</strong></td>
                                            <td><strong style="color: #28a745;">৳ {{ number_format($cost->cost, 2) }}</strong></td>
                                            <td>
                                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editTinModal{{ $cost->id }}"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editTinModal{{ $cost->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); color: white;">
                                                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>খরচ সম্পাদন করুন (টিআইএন)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.cost.update', $cost->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="table_type" value="tin">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-tag me-2"></i>খরচের নাম (বাংলা)</label>
                                                        <input type="text" class="form-control" name="name_bn" value="{{ old('name_bn', $cost->name_bn) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-code me-2"></i>কোড (অপরিবর্তনীয়)</label>
                                                        <input type="text" class="form-control" value="{{ $cost->code }}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label"><i class="fas fa-money-bill-wave me-2"></i>খরচ (টাকা)</label>
                                                        <input type="number" step="0.01" class="form-control" name="cost" value="{{ old('cost', $cost->cost) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeTin{{ $cost->id }}" {{ $cost->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="activeTin{{ $cost->id }}"><i class="fas fa-toggle-on me-2"></i>সক্রিয় রাখুন</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                                                    <button type="submit" class="btn btn-primary" style="background: #ee0979; border: none;"><i class="fas fa-save me-2"></i>আপডেট করুন</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-3 text-muted"><small>কোনো ডেটা নেই</small></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Cost Modal -->
    <div class="modal fade" id="addCostModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>নতুন খরচ যোগ করুন</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.cost.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-table me-2"></i>টেবিল টাইপ</label>
                            <select class="form-select @error('table_type') is-invalid @enderror" name="table_type" required>
                                <option value="">টেবিল নির্বাচন করুন</option>
                                <option value="sign_copy" {{ old('table_type') == 'sign_copy' ? 'selected' : '' }}>সাইন কপি অর্ডার</option>
                                <option value="nid" {{ old('table_type') == 'nid' ? 'selected' : '' }}>এনআইডি টাইপ</option>
                                <option value="passport" {{ old('table_type') == 'passport' ? 'selected' : '' }}>পাসপোর্ট অর্ডার</option>
                                <option value="sim_conversion" {{ old('table_type') == 'sim_conversion' ? 'selected' : '' }}>সিম কনভার্সন</option>
                                <option value="sim_network" {{ old('table_type') == 'sim_network' ? 'selected' : '' }}>সিম নেটওয়ার্ক অর্ডার</option>
                                <option value="tin" {{ old('table_type') == 'tin' ? 'selected' : '' }}>টিআইএন অর্ডার</option>
                            </select>
                            @error('table_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-tag me-2"></i>খরচের নাম (বাংলা)</label>
                            <input type="text" class="form-control @error('name_bn') is-invalid @enderror" name="name_bn" 
                                   value="{{ old('name_bn') }}" required placeholder="যেমন: নিড সাইন কপি">
                            @error('name_bn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-code me-2"></i>কোড</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" 
                                   value="{{ old('code') }}" required placeholder="যেমন: nid_sign_copy">
                            <small class="text-muted">অনন্য কোড ব্যবহার করুন (প্রতিটি খরচের জন্য ভিন্ন)</small>
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-money-bill-wave me-2"></i>খরচ (টাকা)</label>
                            <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" name="cost" 
                                   value="{{ old('cost') }}" required placeholder="০.০০">
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" 
                                       value="1" id="newActive" {{ old('is_active') ? 'checked' : 'checked' }}>
                                <label class="form-check-label" for="newActive">
                                    <i class="fas fa-toggle-on me-2"></i>সক্রিয় রাখুন
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                        <button type="submit" class="btn btn-primary" style="background: #667eea; border: none;">
                            <i class="fas fa-save me-2"></i>সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
</body>
</html>
