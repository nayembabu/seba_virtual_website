<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TIN Orders Management</title>
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
            border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;
        }
        .sidebar-header h3 { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .sidebar-header p  { font-size: 12px; opacity: 0.8; }
        .sidebar-menu { list-style: none; padding: 0 10px; }
        .sidebar-menu li { margin-bottom: 5px; }
        .sidebar-menu a {
            display: flex; align-items: center; padding: 12px 20px;
            color: rgba(255,255,255,0.8); text-decoration: none;
            border-radius: 8px; transition: all 0.3s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255,255,255,0.2); color: white; transform: translateX(5px);
        }
        .sidebar-menu a i { margin-right: 12px; font-size: 18px; width: 20px; text-align: center; }
        .main-content { margin-left: 260px; min-height: 100vh; padding: 20px; transition: all 0.3s; }
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
        .badge-rejected   { background: #f8d7da; color: #721c24; }

        /* WhatsApp link */
        .whatsapp-link { color: #25D366; text-decoration: none; font-weight: 500; }
        .whatsapp-link:hover { color: #128C7E; text-decoration: underline; }
        .whatsapp-link i { margin-right: 4px; }

        /* TIN / NID copyable badge — teal tint */
        .tin-badge {
            font-family: monospace; font-size: 13px;
            background: #f0fafa; color: #0a5a5a;
            padding: 3px 8px; border-radius: 5px;
            border: 1px solid #9fd8d8; white-space: nowrap;
            cursor: pointer; user-select: all;
            display: inline-block; transition: background 0.2s;
        }
        .tin-badge:hover { background: #d4f0f0; }
        .tin-badge .copy-icon { margin-left: 5px; font-size: 11px; color: #0e8c8c; }

        /* Small label above badge */
        .tin-label {
            display: block; font-size: 10px; color: #888;
            margin-bottom: 2px; text-transform: uppercase; letter-spacing: 0.4px;
        }

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
            display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
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

    <!-- Copy toast -->
    <div class="copy-toast" id="copyToast">Copied!</div>

    <div class="main-content">
        <!-- Mobile toggle -->
        <button class="sidebar-toggle" onclick="toggleAdminSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Top Navbar -->
        <div class="top-navbar">
            <h4 class="mb-0">TIN Orders Management</h4>
            <div><span class="text-muted">Welcome, Admin</span></div>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-file-invoice text-primary"></i> টিন অর্ডার ম্যানেজমেন্ট</h2>
                    <p class="text-muted mb-0">সকল টিন সার্ভিস অর্ডারের তালিকা এবং পরিচালনা</p>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h3 id="stat-total">—</h3>
                        <p class="mb-0">Total Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h3 id="stat-pending">—</h3>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h3 id="stat-processing">—</h3>
                        <p class="mb-0">Processing</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h3 id="stat-completed">—</h3>
                        <p class="mb-0">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="Search by NID, TIN, Mobile, name...">
                    </div>
                    <div class="col-md-2">
                        <select id="statusFilter" class="form-select">
                            <option value="">All Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Processing</option>
                            <option value="2">Completed</option>
                            <option value="3">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="typeFilter" class="form-select">
                            <option value="">All Services</option>
                            <option value="1">টিন সার্টিফিকেট অর্ডার</option>
                            <option value="2">নিউ টিন আবেদন</option>
                            <option value="3">জিরো রিটার্ন আবেদন</option>
                            <option value="4">টিন সার্টিফিকেট কারেকশন</option>
                            <option value="5">টিন আইডি পাসওয়ার্ড সেট</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-secondary w-100" onclick="resetFilters()" title="Reset">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100" onclick="exportOrders()">
                            <i class="fas fa-download"></i> Export CSV
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">TIN Orders List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th style="width:50px;">No.</th>
                                <th>User Info</th>
                                <th>Phone</th>
                                <th>TIN / NID</th>
                                <th>Status</th>
                                <th>PDF Upload</th>
                                <th style="width:130px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-spinner fa-spin"></i> Loading orders...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <nav>
                    <ul class="pagination mb-0" id="pagination"></ul>
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
                            <input class="form-check-input" type="radio" name="rejectionReason" id="reason1" value="তথ্য অসম্পূর্ণ বা ভুল">
                            <label class="form-check-label" for="reason1">তথ্য অসম্পূর্ণ বা ভুল</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rejectionReason" id="reason2" value="NID/TIN নম্বর বৈধ নয়">
                            <label class="form-check-label" for="reason2">NID/TIN নম্বর বৈধ নয়</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rejectionReason" id="reason3" value="ডকুমেন্ট প্রয়োজন">
                            <label class="form-check-label" for="reason3">ডকুমেন্ট প্রয়োজন</label>
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
        let currentPage = 1;
        let currentRejectOrderId = null;

        /* ── Bootstrap ── */
        document.addEventListener('DOMContentLoaded', () => {
            loadOrders();
            document.getElementById('searchInput').addEventListener('keyup',  () => { currentPage = 1; loadOrders(); });
            document.getElementById('statusFilter').addEventListener('change', () => { currentPage = 1; loadOrders(); });
            document.getElementById('typeFilter').addEventListener('change',   () => { currentPage = 1; loadOrders(); });
        });

        /* ── Load orders via AJAX ── */
        function loadOrders(page = 1) {
            currentPage = page;
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const type   = document.getElementById('typeFilter').value;
            const params = new URLSearchParams({ page });
            if (search)       params.append('search', search);
            if (status !== '') params.append('status', status);
            if (type)         params.append('type', type);

            fetch(`/admin/tin-orders/get-orders?${params}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                renderOrders(data.orders);
                updateStats(data.stats);
                updatePagination(data.pagination);
            })
            .catch(err => {
                console.error('Error:', err);
                document.getElementById('ordersTableBody').innerHTML =
                    '<tr><td colspan="7" class="text-center py-4 text-danger">Error loading orders. Please try again.</td></tr>';
            });
        }

        /* ── Render rows ── */
        function renderOrders(orders) {
            const tbody = document.getElementById('ordersTableBody');

            if (!orders.length) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-4">
                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i> No orders found
                </td></tr>`;
                return;
            }

            tbody.innerHTML = orders.map((order, index) => {
                /* ── WhatsApp from user phone ── */
                const rawPhone = order.user_phone || order.phone || '';
                const digits   = rawPhone.replace(/\D/g, '');
                const waNumber = digits ? '880' + digits.replace(/^0/, '') : '';
                const phoneHtml = waNumber
                    ? `<a href="https://wa.me/${waNumber}" target="_blank" class="whatsapp-link">
                           <i class="fab fa-whatsapp"></i>${escHtml(rawPhone)}
                       </a>`
                    : '<span class="text-muted">N/A</span>';

                /* ── Extract primary TIN / NID identifier ── */
                const { label: tinLabel, value: tinValue } = extractTinIdentifier(order.form_data, order.type);
                const tinHtml = tinValue
                    ? `<small class="tin-label">${escHtml(tinLabel)}</small>
                       <span class="tin-badge" onclick="copyValue('${escHtml(tinValue)}')" title="Click to copy">
                           ${escHtml(tinValue)}<i class="fas fa-copy copy-icon"></i>
                       </span>`
                    : '<span class="text-muted">—</span>';

                /* ── PDF column ── */
                const hasPdf = order.admin_note && order.admin_note.includes('.pdf');
                const pdfHtml = hasPdf
                    ? `<button class="btn btn-sm btn-success me-1"
                               onclick="downloadPdf(${order.id})" title="Download PDF">
                           <i class="fas fa-download"></i> Download
                       </button>
                       <button class="btn btn-sm btn-outline-secondary reupload-btn"
                               onclick="document.getElementById('pdf-file-${order.id}').click()"
                               title="Re-upload PDF">
                           <i class="fas fa-redo"></i> Re-upload
                       </button>`
                    : `<button class="btn btn-sm btn-primary"
                               onclick="document.getElementById('pdf-file-${order.id}').click()"
                               title="Upload PDF">
                           <i class="fas fa-file-pdf"></i> Upload
                       </button>`;

                /* ── Action toggle ── */
                let actionHtml = '';
                if (order.status == 0) {
                    actionHtml = `
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-success flex-fill" onclick="processOrder(${order.id}, 0)" title="Accept">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-sm btn-danger flex-fill" onclick="openReject(${order.id})" title="Reject">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;
                } else if (order.status == 1 || order.status == 2) {
                    actionHtml = `
                        <button class="btn btn-sm btn-danger w-100" onclick="openReject(${order.id})" title="Reject">
                            <i class="fas fa-times"></i> Reject
                        </button>`;
                } else if (order.status == 3) {
                    actionHtml = `
                        <button class="btn btn-sm btn-success w-100" onclick="processOrder(${order.id}, 3)" title="Accept">
                            <i class="fas fa-check"></i> Accept
                        </button>`;
                }

                return `
                <tr>
                    <td class="text-center fw-semibold text-muted">${(currentPage - 1) * 15 + index + 1}</td>
                    <td>
                        <strong>${escHtml(order.user_name || order.name || 'N/A')}</strong><br>
                        <small class="text-muted">${escHtml(order.user_email || order.email || 'N/A')}</small>
                    </td>
                    <td>${phoneHtml}</td>
                    <td>${tinHtml}</td>
                    <td>${statusBadge(order.status)}</td>
                    <td>
                        <input type="file" id="pdf-file-${order.id}" accept=".pdf"
                               style="display:none;" onchange="uploadPdf(${order.id})">
                        ${pdfHtml}
                    </td>
                    <td>${actionHtml}</td>
                </tr>`;
            }).join('');
        }

        /* ── Extract best TIN/NID identifier from form_data ── */
        function extractTinIdentifier(formData, type) {
            try {
                if (typeof formData === 'string') formData = JSON.parse(formData);
                if (!formData) return { label: '', value: '' };

                if (formData.tin_number)      return { label: 'TIN নম্বর',    value: formData.tin_number };
                if (formData.tin_no)          return { label: 'TIN নম্বর',    value: formData.tin_no };
                if (formData.nid_tin_mobile)  return { label: 'NID/TIN/Mobile', value: formData.nid_tin_mobile };
                if (formData.nid_no)          return { label: 'NID নম্বর',    value: formData.nid_no };
                if (formData.nid)             return { label: 'NID নম্বর',    value: formData.nid };
                if (formData.mobile)          return { label: 'মোবাইল',       value: formData.mobile };
                if (formData.user_id)         return { label: 'User ID',       value: formData.user_id };

                // Fallback: first non-empty value
                for (const [k, v] of Object.entries(formData)) {
                    if (v) return { label: k.replace(/_/g, ' '), value: String(v) };
                }
            } catch (e) { /* ignore */ }
            return { label: '', value: '' };
        }

        /* ── Copy to clipboard ── */
        function copyValue(value) {
            navigator.clipboard.writeText(value).then(() => {
                const toast = document.getElementById('copyToast');
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2000);
            });
        }

        /* ── Stats ── */
        function updateStats(stats) {
            document.getElementById('stat-total').textContent      = stats.total      ?? '—';
            document.getElementById('stat-pending').textContent    = stats.pending    ?? '—';
            document.getElementById('stat-processing').textContent = stats.processing ?? '—';
            document.getElementById('stat-completed').textContent  = stats.completed  ?? '—';
        }

        /* ── Pagination ── */
        function updatePagination(p) {
            const el = document.getElementById('pagination');
            if (!p || p.last_page <= 1) { el.innerHTML = ''; return; }
            let html = '';
            if (p.current_page > 1)
                html += `<li class="page-item"><a class="page-link" href="#" onclick="loadOrders(${p.current_page - 1});return false;">Previous</a></li>`;
            for (let i = 1; i <= p.last_page; i++)
                html += `<li class="page-item ${i === p.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadOrders(${i});return false;">${i}</a></li>`;
            if (p.current_page < p.last_page)
                html += `<li class="page-item"><a class="page-link" href="#" onclick="loadOrders(${p.current_page + 1});return false;">Next</a></li>`;
            el.innerHTML = html;
        }

        /* ── Status actions ── */
        function processOrder(orderId, currentStatus) {
            const newStatus = (currentStatus == 0 || currentStatus == 3) ? 1 : 2;
            updateOrderStatus(orderId, newStatus);
        }

        function openReject(id) {
            currentRejectOrderId = id;
            document.querySelectorAll('input[name="rejectionReason"]').forEach(r => r.checked = false);
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }

        function confirmReject() {
            const selected = document.querySelector('input[name="rejectionReason"]:checked');
            if (!selected) { alert('অনুগ্রহ করে বাতিলের কারণ নির্বাচন করুন'); return; }
            bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
            updateOrderStatus(currentRejectOrderId, 3, selected.value);
        }

        function updateOrderStatus(orderId, status, reason = '') {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/admin/tin-orders/${orderId}/update-status`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify({ status, reason })
            })
            .then(r => r.json())
            .then(d => {
                if (d.success) loadOrders(currentPage);
                else alert(d.message || 'Error updating order status');
            })
            .catch(() => alert('Error updating order status'));
        }

        /* ── PDF upload ── */
        function uploadPdf(orderId) {
            const input = document.getElementById('pdf-file-' + orderId);
            const file  = input.files[0];
            if (!file) return;

            if (!file.name.toLowerCase().endsWith('.pdf')) {
                alert('শুধুমাত্র PDF ফাইল আপলোড করুন');
                input.value = ''; return;
            }
            if (file.size > 10 * 1024 * 1024) {
                alert('ফাইলের সাইজ ১০ MB এর বেশি হতে পারবে না');
                input.value = ''; return;
            }

            const formData = new FormData();
            formData.append('pdf', file);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const btn = input.nextElementSibling;
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...'; }

            fetch(`/admin/tin-orders/${orderId}/upload-pdf`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: formData
            })
            .then(r => r.json())
            .then(d => {
                input.value = '';
                if (d.success) {
                    loadOrders(currentPage);
                } else {
                    alert(d.message || 'PDF আপলোড করতে সমস্যা হয়েছে');
                    if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fas fa-file-pdf"></i> Upload'; }
                }
            })
            .catch(err => {
                alert('PDF আপলোড করতে সমস্যা হয়েছে: ' + err.message);
                input.value = '';
                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fas fa-file-pdf"></i> Upload'; }
            });
        }

        function downloadPdf(orderId) {
            window.open(`/admin/tin-orders/${orderId}/download-pdf`, '_blank');
        }

        /* ── Filters / Export ── */
        function resetFilters() {
            document.getElementById('searchInput').value  = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('typeFilter').value   = '';
            currentPage = 1;
            loadOrders();
        }

        function exportOrders() {
            window.location.href = '/admin/tin-orders/export';
        }

        /* ── Helpers ── */
        function statusBadge(status) {
            const map = {
                0: '<span class="badge-status badge-pending">Pending</span>',
                1: '<span class="badge-status badge-processing">Processing</span>',
                2: '<span class="badge-status badge-completed">Completed</span>',
                3: '<span class="badge-status badge-rejected">Rejected</span>',
            };
            return map[status] ?? `<span class="badge-status">${status}</span>`;
        }

        function escHtml(str) {
            return String(str ?? '')
                .replace(/&/g,'&amp;').replace(/</g,'&lt;')
                .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }
    </script>
</body>
</html>