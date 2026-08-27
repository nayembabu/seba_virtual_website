@extends("layouts.admin")

@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Promo Codes</h4>
                    <a href="{{ route("admin.promo-codes.create") }}" class="btn btn-primary">Add New Promo Code</a>
                </div>
                <div class="card-body">
                    @if (session("success"))
                        <div class="alert alert-success">{{ session("success") }}</div>
                    @endif
                    @if (session("error"))
                        <div class="alert alert-danger">{{ session("error") }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered" id="promoCodesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Usage Limit</th>
                                    <th>Times Used</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Active</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($promoCodes as $promoCode)
                                    <tr>
                                        <td>{{ $promoCode->id }}</td>
                                        <td>{{ $promoCode->code }}</td>
                                        <td>{{ $promoCode->usage_limit }}</td>
                                        <td>{{ $promoCode->times_used }}</td>
                                        <td>{{ $promoCode->promo_amount }}</td>
                                        <td>{{ ucfirst($promoCode->promo_type) }}</td>
                                        <td>
                                            @if ($promoCode->is_active)
                                                <span class="badge bg-success text-white">Yes</span>
                                            @else
                                                <span class="badge bg-danger text-white">No</span>
                                            @endif
                                        </td>
                                        <td>{{ $promoCode->created_at->format("d M Y") }}</td>
                                        <td>
                                            <a href="{{ route("admin.promo-codes.edit", $promoCode->id) }}" class="btn btn-sm btn-info">Edit</a>
                                            <form action="{{ route("admin.promo-codes.destroy", $promoCode->id) }}" method="POST" onsubmit="return confirm("Are you sure?");" style="display:inline-block;">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No promo codes found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $promoCodes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
<script>
    $(document).ready(function() {
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#promoCodesTable').DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']]
            });
        }
    });
</script>
@endpush