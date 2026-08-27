@extends("layouts.admin")

@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Service Charges</h4>
                    <!-- Button to trigger new service charge modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createServiceChargeModal">
                        Add New Service Charge
                    </button>
                </div>
                <div class="card-body">
                    @if (session("success"))
                        <div class="alert alert-success">{{ session("success") }}</div>
                    @endif
                    @if (session("error"))
                        <div class="alert alert-danger">{{ session("error") }}</div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Services</h5>
                                    <p class="card-text">{{ $totalServices }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Active Services</h5>
                                    <p class="card-text">{{ $totalActive }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Inactive Services</h5>
                                    <p class="card-text">{{ $totalInactive }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Active Amount</h5>
                                    <p class="card-text">{{ $totalAmount }} BDT</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="serviceChargesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Service Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>{{ $service->service_name }}</td>
                                        <td>{{ $service->amount }}</td>
                                        <td>
                                            @if ($service->status)
                                                <span class="badge bg-success text-white">Active</span>
                                            @else
                                                <span class="badge bg-danger text-white">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Button to trigger edit modal -->
                                            <button type="button" class="btn btn-sm btn-info edit-service-charge" data-bs-toggle="modal" data-bs-target="#editServiceChargeModal" data-id="{{ $service->id }}" data-name="{{ $service->service_name }}" data-amount="{{ $service->amount }}" data-status="{{ $service->status }}">
                                                Edit
                                            </button>
                                            <form action="{{ route("admin.service-charges.destroy", $service->id) }}" method="POST" onsubmit="return confirm("Are you sure you want to delete this service charge?");" style="display:inline-block;">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No service charges found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Service Charge Modal -->
<div class="modal fade" id="createServiceChargeModal" tabindex="-1" aria-labelledby="createServiceChargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createServiceChargeModalLabel">Add New Service Charge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route("admin.service-charges.store") }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="service_name" class="form-label">Service Name</label>
                        <input type="text" class="form-control" id="service_name" name="service_name" value="{{ old("service_name") }}" required>
                        @error("service_name")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old("amount", 0.00) }}" required min="0">
                        @error("amount")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ old("status", 1) ? "checked" : "" }}>
                        <label class="form-check-label" for="status">Active</label>
                        @error("status")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Service Charge</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Service Charge Modal -->
<div class="modal fade" id="editServiceChargeModal" tabindex="-1" aria-labelledby="editServiceChargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceChargeModalLabel">Edit Service Charge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editServiceChargeForm" method="POST">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_service_name" class="form-label">Service Name</label>
                        <input type="text" class="form-control" id="edit_service_name" name="service_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="edit_amount" name="amount" required min="0">
                        @error("amount")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="edit_status" name="status" value="1">
                        <label class="form-check-label" for="edit_status">Active</label>
                        @error("status")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Service Charge</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push("js")
<script>
    $(document).ready(function() {
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#serviceChargesTable').DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']]
            });
        }

        // Handle edit modal data population
        $(".edit-service-charge").on("click", function() {
            var id = $(this).data("id");
            var name = $(this).data("name");
            var amount = $(this).data("amount");
            var status = $(this).data("status");

            $("#editServiceChargeForm").attr("action", "{{ route("admin.service-charges.index") }}/" + id);
            $("#edit_service_name").val(name);
            $("#edit_amount").val(amount);
            $("#edit_status").prop("checked", status == 1);
        });
    });
</script>
@endpush
