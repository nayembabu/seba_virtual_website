@extends('admin.layouts.app')
@section('title') @lang('Manual Recharge Requests') @endsection

@section('content')
<style>
:root {
    --primary: #2c3e50;
    --secondary: #3498db;
    --accent: #e74c3c;
    --light: #ecf0f1;
    --dark: #2c3e50;
    --success: #2ecc71;
    --warning: #f39c12;
    --danger: #e74c3c;
    --gray: #95a5a6;
}

.admin-container {
    max-width: 1400px;
    margin: 0 auto;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.admin-header {
    background: linear-gradient(120deg, var(--primary), var(--secondary));
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.admin-stats {
    display: flex;
    gap: 15px;
    padding: 1rem 2rem;
    background: var(--light);
    border-bottom: 1px solid #ddd;
    flex-wrap: wrap;
}

.stat-card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    flex: 1;
    min-width: 200px;
    text-align: center;
    border-left: 4px solid var(--secondary);
}

.stat-number {
    font-size: 1.8rem;
    font-weight: bold;
    color: var(--secondary);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--gray);
}

.filter-section {
    padding: 1.5rem 2rem;
    background: white;
    border-bottom: 1px solid #eee;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    align-items: center;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-label {
    font-weight: 600;
    color: var(--dark);
    white-space: nowrap;
}

.table-container {
    padding: 0 2rem 2rem 2rem;
}

.table {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 0;
}

.table thead {
    background: linear-gradient(90deg, var(--primary), var(--secondary));
    color: white;
}

.table th {
    font-weight: 600;
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
    border-radius: 6px;
}

.btn-action {
    border-radius: 6px;
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.reason-input {
    width: 200px;
    border-radius: 6px;
    font-size: 0.85rem;
    padding: 0.4rem 0.75rem;
    display: inline-block;
}

.pagination {
    justify-content: center;
    margin-top: 2rem;
}

.page-item.active .page-link {
    background: var(--secondary);
    border-color: var(--secondary);
}

.page-link {
    color: var(--secondary);
    padding: 0.5rem 0.75rem;
}

.page-link:hover {
    color: var(--primary);
    background: #f8f9fa;
}

.action-cell {
    min-width: 280px;
}

@media (max-width: 992px) {
    .admin-header { flex-direction: column; text-align: center; gap: 15px; }
    .filter-section { flex-direction: column; align-items: flex-start; }
    .table-container { overflow-x: auto; }
    .action-cell { min-width: 240px; }
}
@media (max-width: 576px) {
    .admin-stats { flex-direction: column; }
    .stat-card { min-width: auto; }
    .reason-input { width: 100%; margin-bottom: 10px; }
    .btn-action { width: 100%; justify-content: center; }
}
</style>

<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body p-0">
        <div class="admin-container">
            <div class="admin-header">
                <h1 class="admin-title"><i class="fas fa-money-bill-wave"></i> ????????????????????? ??????????????????????????? ????????????????????????????????????</h1>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left"></i> ??????????????????????????????</a>
                </div>
            </div>

            <div class="admin-stats">
                <div class="stat-card">
                    <div class="stat-number"><span class="badge bg-warning">{{ $pending_count }}</span></div>
                    <div class="stat-label">Pending ???????????????????????????</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><span class="badge bg-success">{{ $approved_count }}</span></div>
                    <div class="stat-label">Approved ???????????????????????????</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><span class="badge bg-danger">{{ $rejected_count }}</span></div>
                    <div class="stat-label">Cancelled ???????????????????????????</div>
                </div>
            </div>

            <div class="filter-section">
                <form action="" method="GET" class="d-flex gap-3 flex-wrap align-items-center w-100">
                    <div class="filter-group">
                        <span class="filter-label"><i class="fas fa-filter"></i> ?????????????????????:</span>
                        <select name="status" class="form-select form-select-sm" style="width: 150px;">
                            <option value="">?????? ???????????????????????????</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Approved</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <span class="filter-label"><i class="fas fa-search"></i> ???????????????:</span>
                        <input type="text" name="q" class="form-control form-control-sm" placeholder="????????????, ??????????????????, TrxID..." value="{{ request('q') ?? '' }}" style="width: 220px;">
                    </div>
                    <button class="btn btn-sm btn-primary"><i class="fas fa-check"></i> Apply</button>
                </form>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>????????????</th>
                                <th>???????????????</th>
                                <th>??????????????????</th>
                                <th>????????????</th>
                                <th>????????????????????? ?????????????????????</th>
                                <th>TrxID</th>
                                <th>???????????????????????????</th>
                                <th>?????????</th>
                                <th>?????????????????????</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recharges as $r)
                            <tr>
                                <td><strong>#{{ $r->id }}</strong></td>
                                <td>
                                    <div>{{ $r->user->email ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $r->user->phone ?? '' }}</small>
                                </td>
                                <td><span class="fw-bold">{{ number_format($r->amount, 2) }}</span> ????????????</td>
                                <td>{{ $r->gateway_id }}</td>
                                <td>{{ $r->sender_number ?? '???' }}</td>
                                <td><code>{{ $r->txid ?? '???' }}</code></td>
                                <td>
                                    @if($r->status == 0)
                                        <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Pending</span>
                                    @elseif($r->status == 1)
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Approved</span>
                                    @elseif($r->status == 2)
                                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Cancelled</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M Y, h:i A') }}</td>
                                <td class="action-cell">
                                    @if($r->status == 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            <form method="post" action="{{ route('admin.approve-recharge', $r->id) }}" class="approve-form d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-action">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <form method="post" action="{{ route('admin.reject-recharge', $r->id) }}" class="reject-form d-inline">
                                                @csrf
                                                <input type="text" name="reason" class="form-control reason-input" placeholder="????????????????????????????????? ????????????" required>
                                                <button type="submit" class="btn btn-danger btn-action mt-1">
                                                    <i class="fas fa-times"></i> Cancel
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($r->status == 2 && $r->note)
                                        <small class="text-muted">????????????: {{ $r->note }}</small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-inbox fs-1 text-muted mb-2"></i>
                                    <p class="text-muted">????????? ????????????????????? ??????????????????????????? ??????????????? ???????????????</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $recharges->appends(request()->query())->links('partials.pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('.approve-form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        Swal.fire({
            title: '????????????????????? ????????????',
            text: '?????? ????????????????????? ??????????????????????????? ???????????? ??????????',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '???????????????',
            cancelButtonText: '??????',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) form[0].submit();
        });
    });

    $('.reject-form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var reason = form.find('input[name="reason"]').val();
        if (!reason.trim()) {
            Swal.fire({ icon: 'warning', title: '???????????? ????????????????????????', text: '????????????????????????????????? ???????????? ???????????????' });
            return;
        }
        Swal.fire({
            title: '????????????????????? ????????????',
            text: '?????? ????????????????????? ??????????????????????????? ???????????? ??????????',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '???????????????',
            cancelButtonText: '??????',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) form[0].submit();
        });
    });
});
</script>
@endpush
