@extends('user.layouts.app')
@section('title')
    নাগরিক সনদ তালিকা
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-file-contract mr-2"></i> নাগরিক সনদ তালিকা
                        </h5>
                        <a href="{{ route('user.nagorik-sonod.create') }}" class="btn btn-primary btn-sm px-4 shadow-sm">
                            <i class="fas fa-plus-circle mr-1"></i> নতুন সনদ
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
                                        <th>@lang('নং')</th>
                                        <th>@lang('নাম')</th>
                                        <th>@lang('সার্টিফিকেট নং')</th>
                                        <th>@lang('এনআইডি নম্বর')</th>
                                        <th>@lang('সার্টিফিকেট')</th>
                                        <th>@lang('যাচাই')</th>
                                        <th>@lang('তারিখ')</th>
                                        <th class="text-center">@lang('অ্যাকশন')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sonods as $key => $sonod)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="font-weight-medium text-dark">{{ $sonod->name }}</td>
                                            <td><span class="badge badge-light border text-muted">{{ $sonod->certificate_number }}</span></td>
                                            <td>{{ $sonod->nid_number }}</td>
                                            <td>
                                                <a href="{{ route('user.nagorik-sonod.show', $sonod->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="fas fa-print mr-1"></i> প্রিন্ট
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('verify.certificate', $sonod->certificate_number) }}" class="btn btn-sm btn-outline-success" target="_blank">
                                                    <i class="fas fa-check-circle mr-1"></i> যাচাই
                                                </a>
                                            </td>
                                            <td>{{ date('d M Y', strtotime($sonod->created_at)) }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <form action="{{ route('user.nagorik-sonod.destroy', $sonod->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই সনদটি মুছে ফেলতে চান?');">
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

@push('js')
<script>
    $(document).ready(function() {
        // Any additional JavaScript if needed
    });
</script>
@endpush