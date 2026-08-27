@extends('user.layouts.app')
@section('title') @lang($title) @endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-list-alt me-2"></i>খতিয়ান লগস</h4>
            <a href="{{ route('user.khatian.create') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-plus"></i> নতুন খতিয়ান
            </a>
        </div>
        <div class="card-body">
            @if($khatians->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>খতিয়ান নং</th>
                                <th>মৌজা</th>
                                <th>জেলা</th>
                                <th>তারিখ</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($khatians as $key => $khatian)
                            <tr>
                                <td>{{ $khatians->firstItem() + $key }}</td>
                                <td>{{ $khatian->khatian_no }}</td>
                                <td>{{ $khatian->mouza }}</td>
                                <td>{{ $khatian->district }}</td>
                                <td>{{ $khatian->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('user.khatian.view', $khatian->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> ভিউ
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $khatians->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <p class="text-muted">কোনো খতিয়ান পাওয়া যায়নি</p>
                    <a href="{{ route('user.khatian.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> প্রথম খতিয়ান তৈরি করুন
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
