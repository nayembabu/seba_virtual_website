@extends('user.layouts.app')

@section('title')
    নিবন্ধন তালিকা
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-baby mr-2"></i> নিবন্ধন তালিকা
                        </h5>
                        <a href="{{ route('user.nibondon.create') }}" class="btn btn-primary btn-sm px-4 shadow-sm">
                            <i class="fas fa-plus-circle mr-1"></i> নতুন নিবন্ধন
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover datatable dt-responsive nowrap w-100">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>নিবন্ধন নং</th>
                                        <th>নাম (বাংলা)</th>
                                        <th>নাম (ইংরেজি)</th>
                                        <th>পিতার নাম</th>
                                        <th>নিবন্ধন তারিখ</th>
                                        <th class="text-center">কার্যক্রম</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $key => $nibondon)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><span class="badge badge-light border text-muted">{{ $nibondon->registration_no }}</span></td>
                                            <td class="font-weight-medium text-dark">{{ $nibondon->name_bn }}</td>
                                            <td>{{ $nibondon->name_en ?? 'N/A' }}</td>
                                            <td>{{ $nibondon->father_name_bn }}</td>
                                            <td>{{ \Carbon\Carbon::parse($nibondon->registration_date)->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('user.nibondon.show', $nibondon->id) }}" class="btn btn-sm btn-outline-primary mr-1" title="প্রিন্ট">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="{{ route('user.nibondon.edit', $nibondon->id) }}" class="btn btn-sm btn-outline-warning mr-1" title="সম্পাদনা">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('user.nibondon.destroy', $nibondon->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')                                           
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="মুছুন" 
                                                        onclick="return confirm('আপনি কি নিশ্চিতভাবে এটি মুছে ফেলতে চান?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .card { border-radius: 10px; }
    .card-header { border-radius: 10px 10px 0 0 !important; border-bottom: 1px solid #f0f0f0; }
    .table thead th { 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
        font-weight: 700; 
        border-bottom: none;
        background: #f8f9fa;
    }
    .table td { vertical-align: middle; font-size: 14px; }
    .badge { padding: 5px 10px; font-weight: 500; border-radius: 4px; }
    .btn-sm { border-radius: 4px; }
</style>
@endpush
