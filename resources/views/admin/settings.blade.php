@extends('layouts.admin')
@section('title')
    @lang("Settings")
@endsection
@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data" id="m-form">
            @method('PUT')
            @csrf

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show small py-2" role="alert">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endforeach
            @endif

            <div class="row">
                <!-- General Settings Card -->
                <div class="col-lg-6 mb-4">
                    <div class="card card-outline card-dark shadow-sm">
                        <div class="card-header bg-dark text-white py-2">
                            <h6 class="card-title m-0 font-weight-normal">
                                <i class="fas fa-cog mr-1"></i> General Settings
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="form-group mb-2">
                                <label for="site_name" class="small mb-1">
                                    <i class="fas fa-globe mr-1 text-muted"></i> Site Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="site_name" id="site_name"
                                       value="{{ $settings['site_name'] ?? '' }}" class="form-control form-control-sm"
                                       placeholder="Your site name" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="min_d" class="small mb-1">
                                    <i class="fas fa-coins mr-1 text-muted"></i> Minimum Recharge <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="min_d" id="min_d"
                                       value="{{ $settings['min_d'] ?? '' }}" class="form-control form-control-sm"
                                       placeholder="0.00" step="0.01" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="site_logo" class="small mb-1">
                                    <i class="fas fa-image mr-1 text-muted"></i> Site Logo
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="site_logo" class="custom-file-input" id="site_logo">
                                    <label class="custom-file-label small" for="site_logo">Choose file</label>
                                </div>
                                @if (isset($settings['site_logo']) && $settings['site_logo'])
                                    <div class="mt-1">
                                        <span class="text-muted small">Current:</span>
                                        <img src="{{ asset('images/' . $settings['site_logo']) }}" alt="Site Logo"
                                             class="img-thumbnail ml-1" style="max-height: 40px;">
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label for="whatsapp_number" class="small mb-1">
                                    <i class="fab fa-whatsapp mr-1 text-success"></i> Whatsapp Number <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="whatsapp_number" id="whatsapp_number"
                                       value="{{ $settings['whatsapp_number'] ?? '' }}" class="form-control form-control-sm"
                                       placeholder="+8801XXXXXXXXX" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="support_email" class="small mb-1">
                                    <i class="fas fa-envelope mr-1 text-muted"></i> Support Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="support_email" id="support_email"
                                       value="{{ $settings['support_email'] ?? '' }}" class="form-control form-control-sm"
                                       placeholder="support@example.com" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- bKash API Settings Card -->
                <div class="col-lg-6 mb-4">
                    <div class="card card-outline card-dark shadow-sm">
                        <div class="card-header bg-dark text-white py-2">
                            <h6 class="card-title m-0 font-weight-normal">
                                <i class="fas fa-money-check-alt mr-1"></i> bKash API Settings
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="form-group mb-2">
                                <label for="bkash-api-status" class="small mb-1">
                                    <i class="fas fa-toggle-on mr-1 text-muted"></i> bKash API Status <span class="text-danger">*</span>
                                </label>
                                <select name="bkash_api_status" id="bkash-api-status" class="form-control form-control-sm">
                                    <option value="0" @if(($settings['bkash_api_status'] ?? '0') == '0') selected @endif>Disabled</option>
                                    <option value="1" @if(($settings['bkash_api_status'] ?? '0') == '1') selected @endif>Enabled</option>
                                </select>
                            </div>

                            <div id="bkash-api-settings-fields" style="display: @if(($settings['bkash_api_status'] ?? '0') == '1') block @else none @endif;">
                                <div class="form-group mb-2">
                                    <label for="bkash_mode" class="small mb-1">bKash Mode <span class="text-danger">*</span></label>
                                    <select name="bkash_mode" id="bkash_mode" class="form-control form-control-sm">
                                        <option value="">Select Mode</option>
                                        <option value="live" @if(($settings['bkash_mode'] ?? '') == 'live') selected @endif>Live</option>
                                        <option value="sandbox" @if(($settings['bkash_mode'] ?? '') == 'sandbox') selected @endif>Sandbox</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bkash_app_key" class="small mb-1">App Key <span class="text-danger">*</span></label>
                                    <input type="text" name="bkash_app_key" id="bkash_app_key"
                                           value="{{ $settings['bkash_app_key'] ?? '' }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bkash_app_secret" class="small mb-1">App Secret <span class="text-danger">*</span></label>
                                    <input type="text" name="bkash_app_secret" id="bkash_app_secret"
                                           value="{{ $settings['bkash_app_secret'] ?? '' }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bkash_username" class="small mb-1">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="bkash_username" id="bkash_username"
                                           value="{{ $settings['bkash_username'] ?? '' }}" class="form-control form-control-sm">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bkash_password" class="small mb-1">Password <span class="text-danger">*</span></label>
                                    <input type="text" name="bkash_password" id="bkash_password"
                                           value="{{ $settings['bkash_password'] ?? '' }}" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div id="personal-bkash-number-field" style="display: @if(($settings['bkash_api_status'] ?? '0') == '0') block @else none @endif;">
                                <div class="form-group mb-2">
                                    <label for="personal_bkash_number" class="small mb-1">
                                        <i class="fas fa-phone mr-1 text-muted"></i> Personal bKash Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="personal_bkash_number" id="personal_bkash_number"
                                           value="{{ $settings['personal_bkash_number'] ?? '' }}" class="form-control form-control-sm"
                                           placeholder="01XXXXXXXXX">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button Row -->
            <div class="row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-success shadow-sm" id="sbtn">
                        <i class="fas fa-save mr-1"></i> Save All Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <style>
        /* Dark header look */
        .card-dark.card-outline {
            border-top: 2px solid #343a40;
        }
        /* Smaller overall typography */
        .card-body label {
            font-size: 0.875rem;
        }
        .form-control-sm {
            font-size: 0.8rem;
        }
        .custom-file-label {
            font-size: 0.8rem;
        }
        .alert small {
            font-size: 0.8rem;
        }
        /* Reduce gap between form groups */
        .form-group {
            margin-bottom: 0.5rem !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).on('change', '#bkash-api-status', function(){
            let status = $(this).val();
            if ( status == '1' ){
                $('#bkash-api-settings-fields').slideDown(150);
                $('#personal-bkash-number-field').slideUp(150);
            } else {
                $('#bkash-api-settings-fields').slideUp(150);
                $('#personal-bkash-number-field').slideDown(150);
            }
        });

        $(document).ready(function(){
            let status = $('#bkash-api-status').val();
            if ( status == '1' ){
                $('#bkash-api-settings-fields').show();
                $('#personal-bkash-number-field').hide();
            } else {
                $('#bkash-api-settings-fields').hide();
                $('#personal-bkash-number-field').show();
            }
            // Update file input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });
        });
    </script>
@endpush