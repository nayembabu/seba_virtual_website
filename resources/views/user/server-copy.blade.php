@extends('user.layouts.app')
@section('title')
    @lang('Server Copy')
@endsection

@section('content')
<div class="container-fluid py-4 bn-layout">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        @endforeach
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <div class="row justify-content-center mb-4">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 60px; height: 60px; background: rgba(37,99,235,0.1);">
                            <i class="fas fa-server text-primary" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="fw-bold" style="color: #1e293b;">সার্ভার কপি</h4>
                        <p class="text-muted small mb-0">নিচের তথ্যগুলো পূরণ করে সার্চ বাটনে ক্লিক করুন</p>
                    </div>

                    <form action="" method="post">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-medium text-dark mb-2" style="font-size: 14px;">
                                <i class="fas fa-cog text-primary me-1"></i> এপিআই সিলেক্ট করুন
                            </label>
                            <select name="api_type" class="form-select shadow-none" required style="height: 48px; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 0 16px; font-size: 14px; background: #f8fafc;">
                                <option value="1">এপিআই ১ (২০৳)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium text-dark mb-2" style="font-size: 14px;">
                                <i class="fas fa-id-card text-primary me-1"></i> আইডি/ভোটার নাম্বার
                            </label>
                            <input class="form-control" type="text" name="nid" value="{{ old('nid') }}" placeholder="১০ বা ১৭ বা ১২ ডিজিট" pattern="[0-9]{10,17}" required style="height: 48px; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 0 16px; font-size: 14px; background: #f8fafc;">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark mb-2" style="font-size: 14px;">
                                <i class="fas fa-calendar-alt text-primary me-1"></i> জন্ম তারিখ (YYYY-MM-DD)
                            </label>
                            <input class="form-control" type="date" name="dob" value="{{ old('dob') }}" required style="height: 48px; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 0 16px; font-size: 14px; background: #f8fafc;">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-medium border-0" style="border-radius: 10px; font-size: 16px; background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                            <i class="fas fa-search me-2"></i> সার্চ করুন
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-history text-primary me-2" style="font-size: 18px;"></i>
                <h5 class="fw-bold mb-0" style="color: #1e293b;">পূর্বের সার্ভার কপি</h5>
            </div>

            <div class="table-responsive">
                <table class="table align-middle datatable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="font-size: 13px; color: #64748b;">#</th>
                            <th style="font-size: 13px; color: #64748b;">১৭ ডিজিট নং</th>
                            <th style="font-size: 13px; color: #64748b;">জন্ম তারিখ</th>
                            <th style="font-size: 13px; color: #64748b;">ডাউনলোড</th>
                            <th style="font-size: 13px; color: #64748b;">সময়</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $item)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $loop->iteration }}</td>
                                <td>{{ $item->voter_no ?? $item->nid_no }}</td>
                                <td>{{ $item->dob }}</td>
                                <td>
                                    <a href="{{ route('user.server-copy-view') }}?id={{ $item->id }}&type=v1&download=1" class="btn btn-sm btn-success me-1 rounded-pill px-3" style="font-size: 12px;">v1</a>
                                    <a href="{{ route('user.server-copy-view') }}?id={{ $item->id }}&type=v2&download=1" class="btn btn-sm btn-primary me-1 rounded-pill px-3" style="font-size: 12px;">v2</a>
                                    <a href="{{ route('user.server-copy-view') }}?id={{ $item->id }}&type=v3&download=1" class="btn btn-sm btn-warning text-white rounded-pill px-3" style="font-size: 12px;">v3</a>
                                </td>
                                <td style="font-size: 13px; color: #64748b;">{{ date('d-m-Y h:i A', strtotime($item->created_at)) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">কোন ডাটা পাওয়া যায়নি</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($history, 'links'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1) !important;
        background: #fff !important;
    }
    .table > :not(caption) > * > * {
        border-bottom: 1px solid #f1f5f9;
        padding: 12px 8px;
    }
    .table > tbody > tr:hover {
        background: #f8fafc;
    }
    .card {
        transition: all 0.2s ease;
    }
    .card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.06) !important;
    }
    @@media (max-width: 768px) {
        .container-fluid { padding: 12px; }
    }
</style>
@endsection