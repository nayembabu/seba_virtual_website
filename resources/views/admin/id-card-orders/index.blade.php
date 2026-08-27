@extends("layouts.admin")

@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">ID Card Orders</h4>
                    <a href="{{ route("admin.id-card-orders.export", ["format" => "csv"]) }}" class="btn btn-info btn-sm me-2">Export CSV</a>
                    <a href="{{ route("admin.id-card-orders.export", ["format" => "pdf"]) }}" class="btn btn-info btn-sm">Export PDF</a>
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
                                    <h5 class="card-title">Total Orders</h5>
                                    <p class="card-text" id="totalOrdersCount"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Orders</h5>
                                    <p class="card-text" id="pendingOrdersCount"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Processing Orders</h5>
                                    <p class="card-text" id="processingOrdersCount"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Completed Orders</h5>
                                    <p class="card-text" id="completedOrdersCount"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="idCardOrdersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>NID</th>
                                    <th>Email</th>
                                    <th>Form Type</th>
                                    <th>Cost</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will populate this -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Order ID:</strong> <span id="detailOrderId"></span></p>
                <p><strong>Name:</strong> <span id="detailName"></span></p>
                <p><strong>NID:</strong> <span id="detailNid"></span></p>
                <p><strong>Email:</strong> <span id="detailEmail"></span></p>
                <p><strong>DOB:</strong> <span id="detailDob"></span></p>
                <p><strong>Form Type:</strong> <span id="detailFormType"></span></p>
                <p><strong>Cost:</strong> <span id="detailCost"></span></p>
                <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                <p><strong>Admin Note:</strong> <span id="detailAdminNote"></span></p>
                <p><strong>User Text:</strong> <span id="detailUserText"></span></p>
                <p><strong>Created At:</strong> <span id="detailCreatedAt"></span></p>
                <p><strong>Updated At:</strong> <span id="detailUpdatedAt"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Order Modal -->
<div class="modal fade" id="rejectOrderModal" tabindex="-1" aria-labelledby="rejectOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectOrderModalLabel">Reject Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectOrderForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reject_reason" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="reject_reason" name="reason" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="reject_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="reject_notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Reject Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload PDF Modal -->
<div class="modal fade" id="uploadPdfModal" tabindex="-1" aria-labelledby="uploadPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPdfModalLabel">Upload PDF for Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadPdfForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">Select PDF File</label>
                        <input class="form-control" type="file" id="pdf_file" name="pdf_file" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Save Notes Modal -->
<div class="modal fade" id="saveNotesModal" tabindex="-1" aria-labelledby="saveNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saveNotesModalLabel">Save Notes for Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveNotesForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="order_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="order_notes" name="text" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Notes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push("js")
<script>
    $(document).ready(function() {
        var idCardOrdersTable = $("#idCardOrdersTable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route("admin.id-card-orders.get-orders") }}",
                type: "GET",
                data: function(d) {
                    d.search = d.search.value; // For search input
                    d.status = $("#statusFilter").val(); // Example for a status filter
                }
            },
            columns: [
                { data: "id", name: "id" },
                { data: "name", name: "name" },
                { data: "nid", name: "nid" },
                { data: "email", name: "email" },
                { data: "form_type_name", name: "form_type_name" },
                { data: "cost", name: "cost" },
                { data: "status", name: "status" },
                {
                    data: "created_at",
                    name: "created_at",
                    render: function(data, type, row) {
                        return moment(data).format("DD M YYYY");
                    }
                },
                {
                    data: "actions",
                    name: "actions",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        let buttons = `
                            <button type="button" class="btn btn-sm btn-info view-details-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">View</button>
                        `;
                        
                        if (row.status_code === 0) { // Pending
                            buttons += `
                                <button type="button" class="btn btn-sm btn-success approve-btn" data-id="${row.id}">Approve</button>
                                <button type="button" class="btn btn-sm btn-danger reject-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#rejectOrderModal">Reject</button>
                            `;
                        } else if (row.status_code === 1) { // Processing
                            buttons += `
                                <button type="button" class="btn btn-sm btn-primary upload-pdf-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#uploadPdfModal">Upload PDF</button>
                                <button type="button" class="btn btn-sm btn-secondary save-notes-btn" data-id="${row.id}" data-notes="${row.text || ''}" data-bs-toggle="modal" data-bs-target="#saveNotesModal">Notes</button>
                            `;
                        } else if (row.status_code === 2) { // Rejected
                            buttons += `
                                <button type="button" class="btn btn-sm btn-secondary save-notes-btn" data-id="${row.id}" data-notes="${row.text || ''}" data-bs-toggle="modal" data-bs-target="#saveNotesModal">Notes</button>
                            `;
                        } else if (row.status_code === 3) { // Completed
                            buttons += `
                                <a href="/admin/id-card-orders/${row.id}/download-pdf" class="btn btn-sm btn-primary" target="_blank">Download PDF</a>
                                <button type="button" class="btn btn-sm btn-secondary save-notes-btn" data-id="${row.id}" data-notes="${row.text || ''}" data-bs-toggle="modal" data-bs-target="#saveNotesModal">Notes</button>
                            `;
                        }
                        
                        return buttons;
                    }
                }
            ]
        });

        // Update stats on table draw
        idCardOrdersTable.on("xhr.dt", function (e, settings, json, xhr) {
            $("#totalOrdersCount").text(json.stats.total);
            $("#pendingOrdersCount").text(json.stats.pending);
            $("#processingOrdersCount").text(json.stats.processing);
            $("#completedOrdersCount").text(json.stats.completed);
        });

        // Handle View Details button click
        $("#idCardOrdersTable").on("click", ".view-details-btn", function() {
            var orderId = $(this).data("id");
            $.ajax({
                url: `/admin/id-card-orders/${orderId}/details`, // Assuming a route like admin.id-card-orders.details exists
                type: "GET",
                success: function(response) {
                    // Populate modal with response data
                    $("#detailOrderId").text(response.id);
                    $("#detailName").text(response.name);
                    $("#detailNid").text(response.nid);
                    $("#detailEmail").text(response.email);
                    $("#detailDob").text(response.dob);
                    $("#detailFormType").text(response.form_type_name);
                    $("#detailCost").text(response.cost);
                    $("#detailStatus").text(response.status);
                    $("#detailAdminNote").text(response.admin_note || "N/A");
                    $("#detailUserText").text(response.text || "N/A");
                    $("#detailCreatedAt").text(moment(response.created_at).format("DD M YYYY HH:mm"));
                    $("#detailUpdatedAt").text(moment(response.updated_at).format("DD M YYYY HH:mm"));
                    
                    var orderDetailsModal = new bootstrap.Modal(document.getElementById("orderDetailsModal"));
                    orderDetailsModal.show();
                },
                error: function(xhr) {
                    alert("Error fetching order details.");
                }
            });
        });

        // Handle Approve button click
        $("#idCardOrdersTable").on("click", ".approve-btn", function() {
            var orderId = $(this).data("id");
            if (confirm("Are you sure you want to approve this order?")) {
                $.ajax({
                    url: `/admin/id-card-orders/${orderId}/approve`,
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            idCardOrdersTable.ajax.reload(); // Reload DataTables
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert("Error approving order.");
                    }
                });
            }
        });

        // Handle Reject button click (prepares modal)
        $("#idCardOrdersTable").on("click", ".reject-btn", function() {
            var orderId = $(this).data("id");
            $("#rejectOrderForm").attr("action", `/admin/id-card-orders/${orderId}/reject`);
            // Clear previous values
            $("#reject_reason").val("");
            $("#reject_notes").val("");
        });

        // Handle Reject Form submission
        $("#rejectOrderForm").on("submit", function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var actionUrl = $(this).attr("action");

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $("#rejectOrderModal").modal("hide");
                        idCardOrdersTable.ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert("Error rejecting order.");
                }
            });
        });

        // Handle Upload PDF button click (prepares modal)
        $("#idCardOrdersTable").on("click", ".upload-pdf-btn", function() {
            var orderId = $(this).data("id");
            $("#uploadPdfForm").attr("action", `/admin/id-card-orders/${orderId}/upload-pdf`);
            $("#pdf_file").val(""); // Clear previous file selection
        });

        // Handle Upload PDF Form submission
        $("#uploadPdfForm").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var actionUrl = $(this).attr("action");

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $("#uploadPdfModal").modal("hide");
                        idCardOrdersTable.ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert("Error uploading PDF.");
                }
            });
        });

        // Handle Save Notes button click (prepares modal)
        $("#idCardOrdersTable").on("click", ".save-notes-btn", function() {
            var orderId = $(this).data("id");
            var notes = $(this).data("notes");
            $("#saveNotesForm").attr("action", `/admin/id-card-orders/${orderId}/save-notes`);
            $("#order_notes").val(notes);
        });

        // Handle Save Notes Form submission
        $("#saveNotesForm").on("submit", function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var actionUrl = $(this).attr("action");

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $("#saveNotesModal").modal("hide");
                        idCardOrdersTable.ajax.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert("Error saving notes.");
                }
            });
        });
    });
</script>
@endpush