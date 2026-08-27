@extends("user.layouts.app")

@section("title")
    @lang("Update Password")
@endsection

@section("content")

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0"><i class="fas fa-lock"></i> @lang("Update Password")</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session("success"))
                        <div class="alert alert-success mb-4">
                            {{ session("success") }}
                        </div>
                    @endif
                    
                    <form action="{{ route("user.updatePassword") }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">@lang("Current Password") *</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">@lang("New Password") *</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="new_password_confirm" class="form-label">@lang("Confirm New Password") *</label>
                            <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">@lang("Update Password")</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push("js")
    <script>
        $(document).ready(function () {
            // Add any custom JS for password if needed
        });
    </script>
@endpush