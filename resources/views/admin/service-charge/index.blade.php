@extends('layouts.admin')

@section('title', 'Service Charges')

@section('page_title', 'Service Charges')
@section('page_subtitle', 'Manage service fees and pricing')

@section('content')
<div class="row g-4">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-primary">
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalServices ?? 0 }}</div>
                <div class="stat-label">Total Services</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalActive ?? 0 }}</div>
                <div class="stat-label">Active</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-warning">
            <div class="stat-icon">
                <i class="fas fa-pause-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalInactive ?? 0 }}</div>
                <div class="stat-label">Inactive</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-info">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">৳{{ number_format($totalAmount ?? 0, 2) }}</div>
                <div class="stat-label">Total Amount</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2 text-primary"></i>
            Service Charges ({{ $services->count() }} items)
        </h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="fas fa-plus me-1"></i>
            Add New Service
        </button>
    </div>

    <div class="card-body">
        <!-- Alerts -->
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

        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.service-charges.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search services..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search') || request('status') !== null && request('status') !== '')
                        <a href="{{ route('admin.service-charges.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.service-charges.index') }}" class="d-flex gap-2">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-hover" id="serviceChargesTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Service Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td><strong>{{ $service->id }}</strong></td>
                            <td>
                                <span class="service-code">{{ $service->service_name }}</span>
                            </td>
                            <td>
                                <strong class="text-primary">৳{{ number_format($service->amount, 2) }}</strong>
                            </td>
                            <td>
                                @if($service->status)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-pause-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted">
                                {{ $service->created_at ? $service->created_at->format('M d, Y') : '-' }}
                            </td>
                            <td class="text-muted">
                                {{ $service->updated_at ? $service->updated_at->format('M d, Y H:i') : '-' }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $service->id }}"
                                            title="Edit Service">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.service-charges.destroy', $service->id) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this service charge?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Service">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">No service charges found</h5>
                                <p class="text-muted">Add your first service charge to get started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Edit Modals -->
@foreach($services as $service)
<div class="modal fade" id="editModal{{ $service->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Service Charge
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.service-charges.update', $service->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Service Name</label>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $service->service_name }}" disabled>
                        <small class="text-muted">
                            <i class="fas fa-lock me-1"></i>Service name cannot be changed
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount (৳)</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" min="0" class="form-control" 
                                   name="amount" value="{{ old('amount', $service->amount) }}" required>
                        </div>
                        @error('amount')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                   id="status{{ $service->id }}" {{ $service->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="status{{ $service->id }}">
                                <i class="fas fa-toggle-on me-1"></i>Active Status
                            </label>
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

<!-- Add New Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Service Charge
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.service-charges.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Service Name</label>
                        <input type="text" class="form-control @error('service_name') is-invalid @enderror"
                               name="service_name" value="{{ old('service_name') }}" required
                               placeholder="e.g., passport, nid, bmet">
                        <small class="text-muted">Use lowercase, no spaces (e.g., passport, nid, bmet)</small>
                        @error('service_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount (৳)</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" min="0" class="form-control @error('amount') is-invalid @enderror"
                                   name="amount" value="{{ old('amount', '0.00') }}" required
                                   placeholder="0.00">
                        </div>
                        @error('amount')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                   id="newStatus" checked>
                            <label class="form-check-label" for="newStatus">
                                <i class="fas fa-toggle-on me-1"></i>Active Status
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Add Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .service-code {
        font-family: 'Courier New', monospace;
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    .table th {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }

    .modal-header {
        border-bottom: none;
    }

    .input-group-text {
        background: #e9ecef;
        border: 1px solid #ced4da;
        color: #495057;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group {
            flex-direction: column;
        }
        
        .btn-group .btn {
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }
    }
</style>
@endpush

@push('js')
<script>
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Re-open modal if there are errors
        @if($errors->any() && old('_modal') === 'edit')
            const errorId = "{{ old('service_id') }}";
            if (errorId) {
                const modal = document.getElementById('editModal' + errorId);
                if (modal) {
                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }
            }
        @endif

        @if($errors->any() && old('_modal') === 'add')
            const addModal = document.getElementById('addServiceModal');
            if (addModal) {
                const bsModal = new bootstrap.Modal(addModal);
                bsModal.show();
            }
        @endif
    });

    // Initialize DataTables if available
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#serviceChargesTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']]
        });
    }
</script>
@endpush
