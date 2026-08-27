@extends('layouts.admin')
@section('title') @lang('Manual Recharge Requests') @endsection
@section('page_title', 'Manual Recharge')

@push('css')
<style>
*{margin:0;padding:0;box-sizing:border-box;}
.container{max-width:1400px;margin:0 auto;}
.header{background:linear-gradient(135deg,#2c3e50,#3498db);color:#fff;padding:20px 25px;border-radius:10px 10px 0 0;}
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:15px;padding:20px;background:#fff;}
.stat{background:#f8f9fa;padding:15px;border-radius:8px;text-align:center;border-left:4px solid #3498db;}
.stat .num{font-size:28px;font-weight:bold;}
.badge{padding:3px 12px;border-radius:12px;display:inline-block;font-size:14px;font-weight:600;}
.badge-pending{background:#ffc107;color:#000;}
.badge-approved{background:#28a745;color:#fff;}
.badge-cancelled{background:#dc3545;color:#fff;}
.filter-bar{background:#fff;padding:15px 20px;display:flex;gap:10px;flex-wrap:wrap;align-items:center;border-bottom:1px solid #dee2e6;}
.table-wrap{background:#fff;padding:20px;border-radius:0 0 10px 10px;overflow-x:auto;}
table{width:100%;border-collapse:collapse;}
th{background:#2c3e50;color:#fff;padding:10px 12px;text-align:left;font-size:14px;}
td{padding:10px 12px;border-bottom:1px solid #eee;font-size:14px;vertical-align:middle;}
tr:hover{background:#f8f9fa;}
.btn{padding:6px 16px;border:none;border-radius:5px;cursor:pointer;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:4px;}
.btn-sm{padding:4px 12px;font-size:12px;}
.btn-success{background:#28a745;color:#fff;}
.btn-success:hover{background:#218838;}
.btn-danger{background:#dc3545;color:#fff;}
.btn-danger:hover{background:#c82333;}
.btn-primary{background:#007bff;color:#fff;}
.btn-primary:hover{background:#0069d9;}
.btn-secondary{background:#6c757d;color:#fff;}
.btn-secondary:hover{background:#5a6268;}
.alert{padding:12px 20px;border-radius:5px;margin:15px 0;}
.alert-success{background:#d4edda;color:#155724;border:1px solid #c3e6cb;}
.alert-danger{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;}
input,select{padding:6px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;}
.form-inline{display:flex;gap:10px;flex-wrap:wrap;align-items:center;}
.pagination-info{padding:10px 0;color:#666;font-size:13px;}
.user-cell{display:flex;flex-direction:column;}
.user-cell .name{font-weight:600;color:#333;}
.user-cell .email{font-size:12px;color:#999;}
.action-cell{white-space:nowrap;}
.action-cell form{display:inline-block;}
/* Modal */
.modal-custom .modal-header{background:linear-gradient(135deg,#2c3e50,#3498db);color:#fff;border-radius:8px 8px 0 0;}
.modal-custom .modal-footer{border-top:1px solid #dee2e6;}
.modal-custom .form-select{padding:8px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;}
.reason-text{font-size:12px;color:#999;max-width:140px;white-space:normal;word-break:break-all;}
.trx-code{background:#f1f3f5;padding:2px 8px;border-radius:3px;font-size:12px;font-family:monospace;}
.amount-cell{font-weight:700;color:#2c3e50;}
.quick-add-card{background:#fff;padding:20px;margin:15px 0;border-radius:10px;border:2px dashed #3498db;}
.quick-add-card h4{margin-bottom:12px;color:#2c3e50;}
.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:10px;}
.form-grid input,.form-grid select{padding:8px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px;}
.empty-state{text-align:center;padding:40px;color:#999;}
.empty-state i{font-size:48px;margin-bottom:10px;display:block;}
@media(max-width:768px){.stats{grid-template-columns:1fr;}}
</style>
@endpush

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0"><i class="fas fa-wallet me-2"></i>Manual Recharge Requests</h4>
                <small class="opacity-75"><i class="fas fa-bolt me-1"></i>Manage bKash / Nagad / Rocket recharge requests</small>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats" style="grid-template-columns:repeat(4,1fr);">
            <div class="stat" style="border-left-color:#10b981;"><div class="num" style="color:#10b981;">৳{{ number_format($stats['today'] ?? 0, 0) }}</div><div style="margin-top:4px;color:#666;">📊 Today's Recharge</div></div>
            <div class="stat"><div class="num"><span class="badge badge-pending">{{ $stats['pending'] }}</span></div><div style="margin-top:4px;color:#666;">⏳ Pending</div></div>
            <div class="stat"><div class="num"><span class="badge badge-approved">{{ $stats['approved'] }}</span></div><div style="margin-top:4px;color:#666;">✅ Approved</div></div>
            <div class="stat"><div class="num"><span class="badge badge-cancelled">{{ $stats['cancelled'] }}</span></div><div style="margin-top:4px;color:#666;">❌ Cancelled</div></div>
        </div>

        {{-- Quick Add Request --}}
        <div class="quick-add-card mx-3">
            <h4><i class="fas fa-plus-circle text-primary me-2"></i>Quick Add Request (Testing)</h4>
            <form method="POST" action="{{ route('admin.manual-recharge.store') }}" class="form-grid">
                @csrf
                <input type="text" name="name" placeholder="Name" value="Test User" class="form-control">
                <input type="number" name="amount" placeholder="Amount" value="500" class="form-control">
                <select name="method" class="form-control">
                    <option>bkash</option>
                    <option>nagad</option>
                    <option>rocket</option>
                </select>
                <input type="text" name="sender" placeholder="Sender Number" value="01712345678" class="form-control">
                <input type="text" name="trx" placeholder="TrxID" value="TRX{{ rand(1000, 9999) }}" class="form-control">
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Submit</button>
            </form>
        </div>

        {{-- Filter --}}
        <div class="filter-bar">
            <form method="GET" class="form-inline w-100">
                <select name="status" class="form-select" style="width:auto;">
                    <option value="all">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <input type="text" name="search" placeholder="Search by sender or TrxID..." value="{{ request('search') }}" class="form-control" style="flex:1;min-width:200px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Apply</button>
                <a href="{{ route('admin.manual-recharges') }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-wrap">
            <div class="pagination-info">
                Showing {{ $recharges->firstItem() ?? 0 }} - {{ $recharges->lastItem() ?? 0 }} of {{ $recharges->total() }} requests
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Sender</th>
                        <th>TrxID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>WhatsApp / Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recharges as $r)
                    @php
                        $badge = $r->status == 'pending' ? 'badge-pending' : ($r->status == 'approved' ? 'badge-approved' : 'badge-cancelled');
                        $user = \App\Models\User::find($r->user_id);
                    @endphp
                    <tr>
                        <td><strong>#{{ $r->id }}</strong></td>
                        <td>
                            <div class="user-cell">
                                <span class="name">{{ $user->name ?? 'Unknown' }}</span>
                                <span class="email">{{ $user->email ?? '' }}</span>
                            </div>
                        </td>
                        <td class="amount-cell">{{ number_format($r->amount, 0) }} ৳</td>
                        <td>
                            @switch($r->gateway_id)
                                @case('bKash') <span style="color:#e2136e;font-weight:600;">bKash</span> @break
                                @case('Nagad') <span style="color:#ff7a00;font-weight:600;">Nagad</span> @break
                                @case('Rocket') <span style="color:#8b5cf6;font-weight:600;">Rocket</span> @break
                                @default {{ $r->gateway_id }}
                            @endswitch
                        </td>
                        <td>{{ $r->from ?? 'N/A' }}</td>
                        <td><span class="trx-code">{{ $r->txid ?? 'N/A' }}</span></td>
                        <td style="font-size:12px;color:#666;">{{ $r->created_at->format('d M Y, h:i A') }}</td>
                        <td><span class="badge {{ $badge }}">{{ ucfirst($r->status) }}</span></td>
                        <td class="action-cell">
                            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                <a href="https://wa.me/{{ $user->phone ?? '' }}" target="_blank" title="WhatsApp" style="color:#25D366;font-weight:600;text-decoration:none;white-space:nowrap;">
                                    <i class="fab fa-whatsapp"></i> {{ $user->phone ?? '—' }}
                                </a>
                                @if($r->status == 'pending')
                                    <form method="POST" action="{{ route('admin.manual-recharge.approve', $r->id) }}" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Approve"><i class="fas fa-check"></i></button>
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm" title="Cancel" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $r->id }}"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    {{-- Cancel Modal --}}
                    <div class="modal fade modal-custom" id="cancelModal{{ $r->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('admin.manual-recharge.cancel', $r->id) }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Cancel Request #{{ $r->id }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>User:</strong> {{ $user->name ?? 'Unknown' }} | <strong>Amount:</strong> {{ number_format($r->amount, 0) }} ৳</p>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Cancellation Reason</label>
                                            <select name="reason" class="form-select" required>
                                                <option value="">— Select Reason —</option>
                                                <option value="Insufficient Balance">Insufficient Balance</option>
                                                <option value="Invalid Transaction ID">Invalid Transaction ID</option>
                                                <option value="Wrong Amount">Wrong Amount</option>
                                                <option value="Sender Number Mismatch">Sender Number Mismatch</option>
                                                <option value="Duplicate Request">Duplicate Request</option>
                                                <option value="User Requested">User Requested</option>
                                                <option value="Payment Not Received">Payment Not Received</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Cancel Request</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            No recharge requests found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($recharges->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $recharges->links() }}
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
