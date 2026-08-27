@extends("admin.layouts.app")
@section("title")
    @lang("Edit Profile")
@endsection
@section("content")
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <form action="{{ route("admin.profile.update") }}" method="POST">
                @csrf
                @method("POST") {{-- Using POST method as per routes/admin.php, but it's a PUT operation logically --}}

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session("success"))
                    <div class="alert alert-success">
                        {{ session("success") }}
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" 
                           name="email" 
                           class="form-control @error("email") is-invalid @enderror" 
                           id="email" 
                           value="{{ old("email", $admin->email) }}" 
                           required>
                    @error("email")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" 
                           name="password" 
                           class="form-control @error("password") is-invalid @enderror" 
                           id="password">
                    @error("password")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" 
                           name="password_confirmation" 
                           class="form-control" 
                           id="password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
            </form>
        </div>
    </div>
@endsection
