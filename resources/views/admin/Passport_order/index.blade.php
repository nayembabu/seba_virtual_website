<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Passport Orders Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            position: fixed; left: 0; top: 0;
            height: 100vh; width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 0; z-index: 1000;
            overflow-y: auto; transition: all 0.3s;
        }
        .sidebar-header {
            padding: 20px; text-align: center; color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar-header h3 { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .sidebar-header p  { font-size: 12px; opacity: 0.8; }
        .sidebar-menu { list-style: none; padding: 0 10px; }
        .sidebar-menu li { margin-bottom: 5px; }
        .sidebar-menu a {
            display: flex; align-items: center;
            padding: 12px 20px; color: rgba(255,255,255,0.8);
            text-decoration: none; border-radius: 8px; transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,255,255,0.2); color: white; transform: translateX(5px);
        }
        .sidebar-menu a i { margin-right: 12px; font-size: 18px; width: 20px; text-align: center; }
        .main-content {
            margin-left: 260px; min-height: 100vh;
            padding: 20px; transition: all 0.3s;
        }
        .top-navbar {
            background: white; padding: 15px 30px; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .page-header {
            background: white; padding: 25px; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 25px;
        }

        /* Status badges */
        .badge-status     { padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-pending    { background: #fff3cd; color: #856404; }
        .badge-processing { background: #e7d4f5; color: #5a21b5; }
        .badge-completed  { background: #d1ecf1; color: #0c5460; }
        .badge-cancelled  { background: #f8d7da; color: #721c24; }

        /* WhatsApp link */
        .whatsapp-link { color: #25D366; text-decoration: none; font-weight: 500; }
        .whatsapp-link:hover { color: #128C7E; text-decoration: underline; }
        .whatsapp-link i { margin-right: 4px; }

        /* Passport number badge — copyable */
        .passport-badge {
            font-family: monospace; font-size: 13px;
            background: #f0f7ff; color: #1a4a8a;
            padding: 3px 8px; border-radius: 5px;
            border: 1px solid #b3d0f5; white-space: nowrap;
            cursor: pointer; user-select: all;
            display: inline-block; transition: background 0.2s;
        }
        .passport-badge:hover { background: #dceeff; }
        .passport-badge .copy-icon { margin-left: 5px; font-size: 11px; color: #3a7bd5; }

        /* Copy toast */
        .copy-toast {
            position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%);
            background: #333; color: #fff; padding: 8px 20px;
            border-radius: 20px; font-size: 13px; z-index: 9999;
            opacity: 0; pointer-events: none; transition: opacity 0.3s;
        }
        .copy-toast.show { opacity: 1; }

        .reupload-btn { font-size: 11px; padding: 2px 8px; }

        /* Mobile toggle */
        .sidebar-toggle {
            display: none; position: fixed; top: 15px; left: 15px;
            z-index: 1001;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none; color: white; width: 45px; height: 45px;
            border-radius: 10px; cursor: pointer;
            box-shadow: 0 4px 15px rgba(102,126,234,0.4); transition: all 0.3s;
        }
        .sidebar-toggle:hover { transform: scale(1.05); box-shadow: 0 6px 20px rgba(102,126,234,0.6); }
        .sidebar-toggle i { font-size: 20px; }

        @media (max-width: 768px) {
            .sidebar-toggle { display: block; }
            .sidebar { left: -260px; }
            .main-content { margin-left: 0; padding-top: 70px; }
        }
    </style>
</head>
<body>
    @include('admin.layouts.sidebar')

    <!-- Copy toast notification -->
    <div class="copy-toast" id="copyToast">Passport No. copied!</div>

    <div class="main-content">
        <!-- Mobile toggle -->
        <button class="sidebar-toggle" onclick="toggleAdminSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Top Navbar -->
        <div class="top-navbar">
            <h4 class="mb-0">Passport Orders Management</h4>
            <div><span class="text-muted">Welcome, Admin</span></div>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-passport text-primary"></i> পাসপোর্ট অর্ডার ম্যানেজমেন্ট</h2>
                    <p class="text-muted mb-0">সকল পাসপোর্ট অর্ডারের তালিকা এবং পরিচালনা</p>
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
                        <p class="mb-0">Processing</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h3>{{ $orders->where('status', 2)->count() }}</h3>
                        <p class="mb-0">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-5">
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="Search by name, phone, passport no..."
                               oninput="filterTable()">
                    </div>
                    <div class="col-md-3">
                        <select id="statusFilter" class="form-select" onchange="filterTable()">
                            <option value="">All Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Processing</option>
                            <option value="2">Completed</option>
                            <option value="3">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="formTypeFilter" class="form-select" onchange="filterTable()">
                            <option value="">All Form Types</option>
                            <option value="1">MRP Passport to SB Copy</option>
                            <option value="3">NID/Nibondhon to Passport Info</option>
                            <option value="4">BMET 78% Approve</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-secondary w-100" onclick="resetFilters()" title="Reset">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Passport Orders List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" id="ordersTable">
                        <thead class="bg-light">
                            <tr>
                                <th style="width:50px;">No.</th>
                                <th>User Info</th>
                                <th>Phone</th>
                                <th>Passport No.</th>
                                <th>Status</th>
                                <th>PDF Upload</th>
                                <th style="width:130px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                                @php
                                    $phone    = $order->user->phone ?? null;
                                    $digits   = preg_replace('/\D/', '', $phone ?? '');
                                    $waNumber = $digits ? '880' . ltrim($digits, '0') : null;

                                    // Passport number: try common form_data keys
                                    $formData   = is_string($order->form_data)
                                                    ? json_decode($order->form_data, true)
                                                    : $order->form_data;
                                    $passportNo = $formData['passport_no']
                                                ?? $formData['passport_number']
                                                ?? $formData['passport']
                                                ?? null;
                                @endphp
                                <tr data-status="{{ $order->status }}" data-form-type="{{ $order->form_type }}">

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

                                    <!-- Passport No. (click to copy) -->
                                    <td>
                                        @if($passportNo)
                                            <span class="passport-badge"
                                                  onclick="copyPassport('{{ $passportNo }}')"
                                                  title="Click to copy">
                                                {{ $passportNo }}<i class="fas fa-copy copy-icon"></i>
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
                                            <span class="badge-status badge-processing">Processing</span>
                                        @elseif($order->status == 2)
                                            <span class="badge-status badge-completed">Completed</span>
                                        @elseif($order->status == 3)
                                            <span class="badge-status badge-cancelled">Cancelled</span>
                                        @else
                                            <span class="badge-status">Unknown</span>
                                        @endif
                                    </td>

                                    <!-- PDF Upload -->
                                    <td>
                                        <input type="file" id="pdf-{{ $order->id }}" accept=".pdf"
                                               style="display:none;"
                                               onchange="uploadPDF({{ $order->id }}, this)">

                                        @if($order->admin_note && (str_starts_with($order->admin_note, '/passport_pdfs/') || str_starts_with($order->admin_note, '/storage/') || str_starts_with($order->admin_note, 'uploads/')))
                                            <a href="javascript:void(0)"
                                               onclick="downloadPDF({{ $order->id }})"
                                               class="btn btn-sm btn-success me-1" title="Download PDF">
                                                <i class="fas fa-download"></i> Download
                                            </a>
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

                                    <!-- Action toggle -->
                                    <td>
                                        @if($order->status == 0)
                                            {{-- Pending → Accept + Reject --}}
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-success flex-fill"
                                                        onclick="updateOrderStatus({{ $order->id }}, 1)"
                                                        title="Accept">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger flex-fill"
                                                        onclick="showRejectModal({{ $order->id }})"
                                                        title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @elseif($order->status == 1 || $order->status == 2)
                                            {{-- Processing / Completed → Reject only --}}
                                            <button class="btn btn-sm btn-danger w-100"
                                                    onclick="showRejectModal({{ $order->id }})"
                                                    title="Reject">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        @elseif($order->status == 3)
                                            {{-- Cancelled → Accept --}}
                                            <button class="btn btn-sm btn-success w-100"
                                                    onclick="updateOrderStatus({{ $order->id }}, 1)"
                                                    title="Accept">
                                                <i class="fas fa-check"></i> Accept
                                            </button>
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
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle"></i> অর্ডার বাতিল করুন
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
        /* ── Copy passport number to clipboard ── */
        function copyPassport(value) {
            navigator.clipboard.writeText(value).then(() => {
                const toast = document.getElementById('copyToast');
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2000);
            });
        }

        /* ── Client-side search / filter ── */
        function filterTable() {
            const search     = document.getElementById('searchInput').value.toLowerCase();
            const status     = document.getElementById('statusFilter').value;
            const formType   = document.getElementById('formTypeFilter').value;
            const rows       = document.querySelectorAll('#ordersTable tbody tr[data-status]');

            rows.forEach(row => {
                const text       = row.innerText.toLowerCase();
                const rowStatus  = row.dataset.status;
                const rowForm    = row.dataset.formType;

                const matchSearch   = !search   || text.includes(search);
                const matchStatus   = !status   || rowStatus  === status;
                const matchForm     = !formType || rowForm     === formType;

                row.style.display = (matchSearch && matchStatus && matchForm) ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value  = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('formTypeFilter').value = '';
            filterTable();
        }

        /* ── Status update ── */
        function updateOrderStatus(orderId, newStatus) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/passport-orders/${orderId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(r => r.json())
            .then(d => { if (d.success) location.reload(); })
            .catch(err => console.error('Error:', err));
        }

        /* ── PDF upload ── */
        function uploadPDF(orderId, fileInput) {
            const file = fileInput.files[0];
            if (!file) return;

            if (file.type !== 'application/pdf') {
                alert('Only PDF files are allowed');
                fileInput.value = '';
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                alert('File size must not exceed 10MB');
                fileInput.value = '';
                return;
            }

            const formData = new FormData();
            formData.append('pdf', file);
            formData.append('order_id', orderId);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Show spinner on the button that triggered the input
            const btn = fileInput.previousElementSibling;
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...'; }

            fetch(`/admin/passport-orders/${orderId}/upload-pdf`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: formData
            })
            .then(r => r.json())
            .then(d => {
                fileInput.value = '';
                if (d.success) {
                    updateOrderStatus(orderId, 2); // auto-complete
                } else {
                    alert('Error: ' + d.message);
                    if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fas fa-file-pdf"></i> Upload'; }
                }
            })
            .catch(err => {
                alert('Upload error: ' + err.message);
                fileInput.value = '';
                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fas fa-file-pdf"></i> Upload'; }
            });
        }

        /* ── Download PDF ── */
        function downloadPDF(orderId) {
            const link = document.createElement('a');
            link.href = `/admin/passport-orders/${orderId}/download-pdf`;
            link.download = 'order_' + orderId + '.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        /* ── Rejection modal ── */
        let currentRejectOrderId = null;

        function showRejectModal(orderId) {
            currentRejectOrderId = orderId;
            document.querySelectorAll('input[name="rejectionReason"]').forEach(r => r.checked = false);
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }

        function confirmReject() {
            const selected = document.querySelector('input[name="rejectionReason"]:checked');
            if (!selected) { alert('অনুগ্রহ করে বাতিলের কারণ নির্বাচন করুন'); return; }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/passport-orders/${currentRejectOrderId}/save-rejection-reason`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ rejection_reason: selected.value })
            })
            .then(r => r.json())
            .then(d => {
                if (d.success) {
                    bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
                    updateOrderStatus(currentRejectOrderId, 3);
                } else {
                    alert('ত্রুটি হয়েছে। দয়া করে পুনরায় চেষ্টা করুন।');
                }
            })
            .catch(() => alert('ত্রুটি হয়েছে। দয়া করে পুনরায় চেষ্টা করুন।'));
        }
    </script>
</body>
</html>