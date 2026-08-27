@extends("layouts.admin")

@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Users</h4>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Balance</th>
                                    <th>Created At</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            <div class="form-check form-switch d-flex align-items-center gap-2">
                                                
                                                <input 
                                                    class="form-check-input status-toggle" 
                                                    type="checkbox"
                                                    role="switch"
                                                    id="status_{{ $user->id }}"
                                                    data-id="{{ $user->id }}"
                                                    {{ $user->status == 1 ? 'checked' : '' }}
                                                >

                                                <label 
                                                    class="form-check-label status-label" 
                                                    for="status_{{ $user->id }}"
                                                >
                                                    {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                                </label>

                                            </div>
                                        </td>
                                        <td>
                                        <div class="d-flex align-items-center gap-2">
                                           <span>{{ number_format($user->balance, 2) }} ৳</span>
                                            <div 
                                                    class="badge bg-primary p-1 add-balance-btn" 
                                                    data-id="{{ $user->id }}" 
                                                    data-name="{{ $user->name }}" 
                                                    data-current-balance="{{ $user->balance }}" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#addBalanceModal"
                                                    title="Adjust Balance">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                        </div>
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Balance Modal (Bootstrap 5.3) -->
<div class="modal fade" id="addBalanceModal" tabindex="-1" aria-labelledby="addBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBalanceModalLabel">Adjust Balance for <span id="modalUserName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBalanceForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="modalUserId" name="user_id">
                    <div class="mb-3">
                        <label for="currentBalance" class="form-label">Current Balance</label>
                        <input type="text" class="form-control" id="currentBalance" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Operation</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="add">Add</option>
                            <option value="subtract">Subtract</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push("js")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(function() {
        // Initialize DataTable if plugin is available
        if ($.fn.DataTable) {
            $("#usersTable").DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']]
            });
        }

        // Status toggle (Bootstrap 5 switch)
        $(".status-toggle").on("change", function() {
            const userId = $(this).data("id");
            const status = $(this).prop("checked") ? 1 : 0;
            let isChecked = $(this).is(':checked');
            // label update
            let label = $(this).closest('.form-check').find('.status-label');
            label.text(isChecked ? 'Active' : 'Inactive');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/admin/users/update-status/' + userId + '/' + status,
                success: function(data) {
                    console.log(data.message);
                    toastr.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.error("Error updating status: " + error);
                    toastr.error("Error updating status.");
                }
            });
        });

        // Populate modal when "plus" button is clicked
        $(".add-balance-btn").on("click", function() {
            const userId = $(this).data("id");
            const userName = $(this).data("name");
            const currentBalance = $(this).data("current-balance");

            $("#modalUserId").val(userId);
            $("#modalUserName").text(userName);
            $("#currentBalance").val(currentBalance);
            $("#amount").val('');
            $("#type").val('add');
        });

        // Handle balance adjustment form submission via AJAX
        $("#addBalanceForm").on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: '/admin/users/update-balance',
                data: $(this).serialize(), // Includes CSRF token, user_id, amount, type
                success: function(data) {
                    console.log(data.message);
                    toastr.success(data.message);
                    location.reload(); // Simple reload; for better UX update the specific row
                },
                error: function(xhr, status, error) {
                    console.error("Error updating balance: " + error);
                    toastr.error("Error updating balance.");
                }
            });
        });
    });
</script>
@endpush