@extends('user.layouts.app')
@section('title') DPDC বিল তালিকা @endsection
@section('content')
<div class="container-fluid px-3">
    <div class="card card-primary shadow">
        <div class="card-header" style="background:#00695c;color:#fff;">
            <span><strong>DPDC বিল তালিকা</strong></span>
            <a href="{{ route('user.electricity_bill.create') }}" class="btn btn-warning btn-sm float-right"><i class="fas fa-plus"></i> নতুন বিল</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div style="overflow-x:auto;">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr><th>#</th><th>বিল নং</th><th>গ্রাহক</th><th>ঠিকানা</th><th>মোট বিল</th><th>পরিশোধযোগ্য</th><th>একশন</th></tr>
                    </thead>
                    <tbody>
                    @forelse($objects as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->bill_no ?? '-' }}</td>
                            <td>{{ $item->customer_name ?? '-' }}</td>
                            <td>{{ $item->address ?? '-' }}</td>
                            <td>{{ $item->total_bill ?? '-' }}</td>
                            <td>{{ $item->total_pay ?? '-' }}</td>
                            <td>
                                <a href="{{ route('user.electricity_bill.show', $item->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('user.electricity_bill.edit', $item->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('user.electricity_bill.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('মুছে ফেলবেন?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">কোন বিল পাওয়া যায়নি</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">{{ $objects->links() }}</div>
        </div>
    </div>
</div>
@endsection