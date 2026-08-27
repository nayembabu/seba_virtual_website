<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign Copy Orders Management</title>
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
        .badge-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        .badge-approved {
            background: #d4edda;
            color: #155724;
        }
        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        .badge-completed {
            background: #d1ecf1;
            color: #0c5460;
        }
        .whatsapp-link {
            color: #25D366;
            text-decoration: none;
            font-weight: 500;
        }
        .whatsapp-link:hover {
            color: #128C7E;
            text-decoration: underline;
        }
        .whatsapp-link i {
            margin-right: 4px;
        }
        /* NID badge — copyable */
        .nid-badge {
            font-family: monospace; font-size: 13px;
            background: #f0f4ff; color: #3a4a8a;
            padding: 3px 8px; border-radius: 5px;
            border: 1px solid #c7d3f5; white-space: nowrap;
            cursor: pointer; user-select: all;
            position: relative; display: inline-block;
            transition: background 0.2s;
        }
        .nid-badge:hover { background: #dce6ff; }
        .nid-badge .copy-icon { margin-left: 5px; font-size: 11px; color: #667eea; }
        .reupload-btn {
            font-size: 11px;
            padding: 2px 8px;
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

        .copy-toast {
            position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%);
            background: #333; color: #fff; padding: 8px 20px;
            border-radius: 20px; font-size: 13px; z-index: 9999;
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s;
        }
        .copy-toast.show { opacity: 1; }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
            .sidebar {
                left: -260px;
            }
            .main-content {
                margin-left: 0;
                padding-top: 70px;
            }
        }
    </style>
</head>
<body>
    @include('admin.layouts.sidebar')
    <div class="copy-toast" id="copyToast">NID copied!</div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Mobile Menu Toggle Button -->
        <button class="sidebar-toggle" onclick="toggleAdminSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Top Navbar -->
        <div class="top-navbar">
            <h4 class="mb-0">Sign Copy Orders Management</h4>
            <div>
                <span class="text-muted">Welcome, Admin</span>
            </div>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-file-signature text-primary"></i> সাইন কপি অর্ডার ম্যানেজমেন্ট</h2>
                    <p class="text-muted mb-0">সকল সাইন কপি অর্ডারের তালিকা এবং পরিচালনা</p>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h3>{{ $orders->count() }}</h3>
                        <p class="mb-0">Total Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h3>{{ $orders->where('status', 0)->count() }}</h3>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h3>{{ $orders->where('status', 1)->count() }}</h3>
                        <p class="mb-0">Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h3>{{ $orders->where('status', 3)->count() }}</h3>
                        <p class="mb-0">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" placeholder="Search orders by user name, phone, NID...">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option>All Orders</option>
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Rejected</option>
                            <option>Completed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Sign Copy Orders List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 50px;">No.</th>
                                <th>User Info</th>
                                <th>Phone</th>
                                <th>NID</th>
                                <th>Status</th>
                                <th>PDF Upload</th>
                                <th style="width: 130px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                                @php
                                    $phone = $order->user->phone ?? null;
                                    $nid   = $order->form_data['nid'] ?? $order->form_data['nid_number'] ?? null;
                                    // Normalize phone for WhatsApp: strip leading 0, prepend 880
                                    $waNumber = $phone
                                        ? '880' . ltrim(preg_replace('/\D/', '', $phone), '0')
                                        : null;
                                @endphp
                                <tr>
                                    <!-- No. -->
                                    <td class="text-center fw-semibold text-muted">{{ $index + 1 }}</td>

                                    <!-- User Info -->
                                    <td>
                                        <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                    </td>

                                    <!-- Phone (WhatsApp link) -->
                                    <td>
                                        @if($waNumber)
                                            <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="whatsapp-link">
                                                <i class="fab fa-whatsapp"></i>{{ $phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>

                                    <!-- NID -->
                                    <td>
                                        @if($nid)
{{--                                            <span class="nid-badge">{{ $nid }}</span>--}}
                                            <span class="nid-badge" onclick="copyNid('{{ $nid }}')" title="Click to copy">
                                               {{ $nid }}<i class="fas fa-copy copy-icon"></i>
                                           </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if($order->status == 0)
                                            <span class="badge-status badge-pending">Pending</span>
                                        @elseif($order->status == 1)
                                            <span class="badge-status badge-approved">Approved</span>
                                        @elseif($order->status == 2)
                                            <span class="badge-status badge-rejected">Rejected</span>
                                        @elseif($order->status == 3)
                                            <span class="badge-status badge-completed">Completed</span>
                                        @else
                                            <span class="badge-status">Unknown</span>
                                        @endif
                                    </td>

                                    <!-- PDF Upload -->
                                    <td>
                                        <input type="file"
                                               id="pdf-{{ $order->id }}"
                                               accept=".pdf"
                                               style="display: none;"
                                               onchange="uploadPDF({{ $order->id }}, this)">

                                        @if($order->admin_note)
                                            {{-- Download existing PDF --}}
                                            <a href="{{ route('admin.sign-copy-orders.download', $order->admin_note) }}"
                                               class="btn btn-sm btn-success me-1"
                                               title="Download PDF">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                            {{-- Re-upload button --}}
                                            <button class="btn btn-sm btn-outline-secondary reupload-btn"
                                                    onclick="document.getElementById('pdf-{{ $order->id }}').click()"
                                                    title="Re-upload PDF">
                                                <i class="fas fa-redo"></i> Re-upload
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="document.getElementById('pdf-{{ $order->id }}').click()"
                                                    title="Upload PDF">
                                                <i class="fas fa-file-pdf"></i> Upload
                                            </button>
                                        @endif
                                    </td>

                                    <!-- Action (Accept / Reject toggle) -->
                                    <td>
                                        @if($order->status == 2)
                                            {{-- Currently Rejected → show Accept --}}
                                            <button class="btn btn-sm btn-success w-100"
                                                    onclick="approveOrder({{ $order->id }})"
                                                    title="Accept this order">
                                                <i class="fas fa-check"></i> Accept
                                            </button>
                                        @elseif($order->status == 1 || $order->status == 3)
                                            {{-- Currently Approved / Completed → show Reject --}}
                                            <button class="btn btn-sm btn-danger w-100"
                                                    onclick="rejectOrder({{ $order->id }})"
                                                    title="Reject this order">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        @elseif($order->status == 0)
                                            {{-- Pending: offer both --}}
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-success flex-fill"
                                                        onclick="approveOrder({{ $order->id }})"
                                                        title="Accept">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger flex-fill"
                                                        onclick="rejectOrder({{ $order->id }})"
                                                        title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i> No orders found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class="fas fa-times-circle"></i> অর্ডার বাতিল করুন
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3"><strong>বাতিল করার কারণ নির্বাচন করুন:</strong></p>
                    <div class="d-flex flex-column gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rejectionReason" id="reason1" value="নথিপত্র অসম্পূর্ণ বা অবৈধ">
                            <label class="form-check-label" for="reason1">নথিপত্র অসম্পূর্ণ বা অবৈধ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rejectionReason" id="reason2" value="ডকুমেন্টের মান দুর্বল">
                            <label class="form-check-label" for="reason2">ডকুমেন্টের মান দুর্বল</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rejectionReason" id="reason3" value="তথ্য মিলছে না">
                            <label class="form-check-label" for="reason3">তথ্য মিলছে না</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rejectionReason" id="reason4" value="ব্যবহারকারীর বাতিলের অনুরোধ">
                            <label class="form-check-label" for="reason4">ব্যবহারকারীর বাতিলের অনুরোধ</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                    <button type="button" class="btn btn-danger" onclick="confirmReject()">
                        <i class="fas fa-check"></i> নিশ্চিত করুন
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function uploadPDF(orderId, fileInput) {
            const file = fileInput.files[0];
            if (!file) return;

            if (file.size > 10 * 1024 * 1024) {
                alert('File size must not exceed 10MB');
                fileInput.value = '';
                return;
            }
            if (file.type !== 'application/pdf') {
                alert('Only PDF files are allowed');
                fileInput.value = '';
                return;
            }

            const formData = new FormData();
            formData.append('pdf_file', file);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Disable the trigger button while uploading
            const button = fileInput.closest('td').querySelector('button[onclick*="click"]');
            if (button) {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
            }

            fetch(`/admin/sign-copy-orders/${orderId}/upload-pdf`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = '<i class="fas fa-file-pdf"></i> Upload';
                    }
                }
            })
            .catch(err => {
                alert('An error occurred while uploading the PDF: ' + err.message);
                if (button) {
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-file-pdf"></i> Upload';
                }
            });
        }

        let currentRejectOrderId = null;

        function approveOrder(orderId) {
            updateOrderStatus(orderId, 'approve');
        }

        function rejectOrder(orderId) {
            currentRejectOrderId = orderId;
            // Reset radio selection
            document.querySelectorAll('input[name="rejectionReason"]').forEach(r => r.checked = false);
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }

        function confirmReject() {
            const selected = document.querySelector('input[name="rejectionReason"]:checked');
            if (!selected) {
                alert('অনুগ্রহ করে বাতিলের কারণ নির্বাচন করুন');
                return;
            }
            bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
            updateOrderStatusWithReason(currentRejectOrderId, 'reject', selected.value);
        }

        function updateOrderStatus(orderId, action) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/admin/sign-copy-orders/${orderId}/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(() => alert('An error occurred while updating the order'));
        }

        function updateOrderStatusWithReason(orderId, action, reason) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/admin/sign-copy-orders/${orderId}/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status_note: reason })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(() => alert('An error occurred while updating the order'));
        }

        function copyNid(nid) {
            navigator.clipboard.writeText(nid).then(() => {
                const toast = document.getElementById('copyToast');
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2000);
            });
        }
    </script>
</body>
</html>