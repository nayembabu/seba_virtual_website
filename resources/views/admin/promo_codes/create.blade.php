@extends("layouts.admin")

@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Create New Promo Code</h4>
                    <a href="{{ route("admin.promo-codes.index") }}" class="btn btn-secondary">Back to List</a>
                </div>
                <div class="card-body">
                    <form action="{{ route("admin.promo-codes.store") }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="code">Promo Code</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ old("code") }}" required>
                            @error("code")
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="usage_limit">Usage Limit</label>
                            <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="{{ old("usage_limit", 0) }}" required min="0">
                            @error("usage_limit")
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="promo_amount">Promo Amount</label>
                            <input type="number" class="form-control" id="promo_amount" name="promo_amount" value="{{ old("promo_amount", 10) }}" required min="0">
                            @error("promo_amount")
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="promo_type">Promo Type</label>
                            <select class="form-control" id="promo_type" name="promo_type" required>
                                <option value="flat" {{ old("promo_type") == "flat" ? "selected" : "" }}>Flat</option>
                                <option value="percent" {{ old("promo_type") == "percent" ? "selected" : "" }}>Percent</option>
                            </select>
                            @error("promo_type")
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old("is_active", 1) ? "checked" : "" }}>
                                <label class="form-check-label" for="is_active">Is Active</label>
                            </div>
                            @error("is_active")
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Create Promo Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection