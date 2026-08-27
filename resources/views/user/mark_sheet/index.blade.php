@extends('user.layouts.app')
@section('title') মার্কশিট তালিকা @endsection
@section('content')
<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">মার্কশিট তালিকা</h5>
            <a href="{{ route('user.mark_sheet.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> নতুন মার্কশিট
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle datatable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>শিক্ষার্থীর নাম</th>
                        <th>পরীক্ষা</th>
                        <th>রোল</th>
                        <th>বোর্ড</th>
                        <th>জিপিএ</th>
                        <th>ফলাফল</th>
                        <th>একশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($objects as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->student_name }}</td>
                            <td>{{ $item->exam_name }} ({{ $item->year }})</td>
                            <td>{{ $item->roll_no }}</td>
                            <td>{{ $item->board }}</td>
                            <td class="fw-bold">{{ $item->gpa }}</td>
                            <td>
                                <span class="badge bg-{{ $item->result == 'PASSED' ? 'success' : 'danger' }}">{{ $item->result }}</span>
                            </td>
                            <td>
                                <a href="{{ route('user.mark_sheet.show', $item->id) }}" class="btn btn-sm btn-info me-1" title="দেখুন"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('user.mark_sheet.edit', $item->id) }}" class="btn btn-sm btn-primary me-1" title="এডিট"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('user.mark_sheet.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('মুছে ফেলবেন?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="ডিলিট"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">কোন মার্কশিট পাওয়া যায়নি</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection