@extends('user.layouts.app')
@section('title') @lang($title) @endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-list-alt me-2"></i>ডিসিআর লগস</h4>
            <a href="{{ route('user.dcr.create') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-plus"></i> নতুন ডিসিআর
            </a>
        </div>
        <div class="card-body">
            @if($dcrs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>ডিসিআর নং</th>
                                <th>আবেদনকারী</th>
                                <th>অফিস</th>
                                <th>তারিখ</th>
                                <th>ইউনিক কোড</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dcrs as $key => $dcr)
                            <tr>
                                <td>{{ $dcrs->firstItem() + $key }}</td>
                                <td>{{ $dcr->dcr_no }}</td>
                                <td>{{ $dcr->applicant_name }}</td>
                                <td>{{ $dcr->office_address }}</td>
                                <td>{{ $dcr->created_at->format('d/m/Y') }}</td>
                                <td>{{ $dcr->unique_code }}</td>
                                <td>
                                    <a href="{{ route('user.dcr.view', $dcr->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> ভিউ
                                    </a>
                                    <a href="{{ route('user.dcr.download', $dcr->id) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> ডাউনলোড
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $dcrs->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <p class="text-muted">কোনো ডিসিআর পাওয়া যায়নি</p>
                    <a href="{{ route('user.dcr.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> প্রথম ডিসিআর তৈরি করুন
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection