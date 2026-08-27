@extends('user.layouts.app')

@section('title')
    @lang('Profile')
@endsection

@section('content')

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0"><i class="fas fa-user-circle"></i> @lang('Profile Settings')</h4>
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

                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('user.updateProfile') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">@lang('Name') *</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">@lang('Email') *</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" disabled>
                                <small class="form-text text-muted">@lang('Email cannot be changed.')</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">@lang('Phone') *</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">@lang('Gender') *</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="">@lang('Select Gender')</option>
                                    <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>@lang('Male')</option>
                                    <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>@lang('Female')</option>
                                    <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>@lang('Other')</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nid" class="form-label">@lang('NID')</label>
                                <input type="text" name="nid" id="nid" class="form-control" value="{{ old('nid', $user->nid) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">@lang('Date of Birth')</label>
                                <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob', $user->dob) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="telegram_id" class="form-label">@lang('Telegram ID')</label>
                            <input type="text" name="telegram_id" id="telegram_id" class="form-control" value="{{ old('telegram_id', $user->telegram_id) }}">
                            <small class="form-text text-muted">@lang('Optional: Enter your Telegram username for notifications.')</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">@lang('Update Profile')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Add any custom JS for profile if needed
        });
    </script>
@endpush