@extends('user.layouts.app')
@section('title') আমার অর্ডার @endsection
@section('content')
<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="mb-0">আমার অর্ডার সমূহ</h5>
            <a href="{{ route('user.new-application') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> নতুন অর্ডার
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>নাম</th>
                        <th>NID</th>
                        <th>টাইপ</th>
                        <th>তারিখ</th>
                        <th>স্ট্যাটাস</th>
                        <th>একশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $app->name ?? 'N/A' }}</td>
                            <td>{{ $app->nid ?? 'N/A' }}</td>
                            <td><span class="badge bg-info">{{ strtoupper($app->type ?? 'N/A') }}</span></td>
                            <td>{{ $app->created_at ? $app->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                            <td>
                                @php
                                    $st = $app->status ?? '0';
                                    $badge = $st == '2' ? 'success' : ($st == '1' ? 'info' : ($st == '3' ? 'danger' : 'warning'));
                                    $label = $st == '2' ? 'সফল' : ($st == '1' ? 'প্রক্রিয়াধীন' : ($st == '3' ? 'বাতিল' : 'পেন্ডিং'));
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                            </td>
                            <td>
                                @if($app->file)
                                <a href="{{ asset($app->file) }}" class="btn btn-sm btn-success" target="_blank" title="ডাউনলোড"><i class="fas fa-download"></i></a>
                                @else
                                <span class="text-muted" style="font-size:12px;">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">কোন অর্ডার পাওয়া যায়নি</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection