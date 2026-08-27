@extends('layouts.admin')

@section('title', 'Order Charges')

@section('page_title', 'Order Charges')
@section('page_subtitle', 'Manage per-order type pricing')

@section('content')


    <!-- Alerts -->
    <div class="mt-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-circle me-2"></i>Error!</strong>
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
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- One card per table, equal height -->
    <div class="row g-4 mt-1 align-items-stretch">
        @foreach($groups as $groupKey => $group)
            <div class="col-lg-6 col-md-6 d-flex">
                <div class="card order-charge-card h-100 w-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas {{ $group['icon'] }} me-2 text-primary"></i>
                            {{ $group['title'] }}
                        </h6>
                        <span class="badge bg-light text-dark border">{{ $group['items']->count() }} items</span>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="table-responsive flex-grow-1">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead>
                                <tr>
                                    <th width="40">#</th>
                                    <th>Type</th>
                                    <th width="110">Amount</th>
                                    <th width="90">Status</th>
                                    <th width="60">Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($group['items'] as $item)
                                    <tr>
                                        <td class="text-muted">{{ $item->id }}</td>
                                        <td>
                                            <div>{{ $item->name_bn }}</div>
                                            <small class="text-muted service-code">{{ $item->code }}</small>
                                        </td>
                                        <td>
                                            <strong class="text-primary">৳{{ number_format($item->cost, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCost-{{ $groupKey }}-{{ $item->id }}"
                                                    title="Edit Amount">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No items found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Edit-cost modals (amount only, one per row across all tables) -->
    @foreach($groups as $groupKey => $group)
        @foreach($group['items'] as $item)
            <div class="modal fade" id="editCost-{{ $groupKey }}-{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h6 class="modal-title">
                                <i class="fas fa-edit me-2"></i>Edit Amount
                            </h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('admin.order-charges.update', ['type' => $groupKey, 'id' => $item->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <input type="text" class="form-control bg-light" value="{{ $item->name_bn }}" disabled>
                                    <small class="text-muted">
                                        <i class="fas fa-lock me-1"></i>Only the amount can be changed here
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Amount (৳)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                               name="cost" value="{{ old('cost', $item->cost) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
@endsection

@push('css')
    <style>
        .order-charge-card {
            border-radius: 0.5rem;
        }

        .order-charge-card .card-header {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .service-code {
            font-family: 'Courier New', monospace;
        }

        .order-charge-card .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
            font-size: 0.8rem;
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.6rem;
        }

        .modal-header {
            border-bottom: none;
        }

        .input-group-text {
            background: #e9ecef;
            border: 1px solid #ced4da;
            color: #495057;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
@endpush