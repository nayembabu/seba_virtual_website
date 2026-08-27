@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
    @php
        $serviceCharge = \App\Models\ServiceCharge::getCharge('land');
    @endphp
<div class="container-fluid bn-layout">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary font-weight-bold">
                        <i class="fas fa-map-marked-alt mr-2"></i> ভূমি উন্নয়ন কর তালিকা
                    </h5>
                    <a href="{{route('user.land.create')}}" class="btn btn-primary btn-sm px-4 shadow-sm">
                        <i class="fas fa-plus-circle mr-1"></i> কর দিন
                        </a>
                    </div>
                    <div class="card-body">
                        @if($serviceCharge)
                            <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1 font-weight-bold">সার্ভিস চার্জ</h6> 
                                        <p class="mb-0 small text-muted">প্রতিটি ভূমি উন্নয়ন কর পরিশোধের জন্য <span class="font-weight-bold text-danger">{{ number_format($serviceCharge, 2) }}</span> টাকা কাটা হবে।</p>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover datatable dt-responsive nowrap w-100">
                                <thead class="thead-light">
                                    <tr>
                                        <th>@lang('আইডি')</th>
                                        <th>@lang('সিটি/পৌর/ইউনিয়ন নাম')</th>
                                        <th>@lang('মালিক')</th>
                                        <th>@lang('ক্রমিক নং')</th>
                                        <th>@lang('তারিখ')</th>
                                        <th class="text-center">@lang('অ্যাকশান')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($objects as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="font-weight-medium text-dark">{{ $data->office_name }}</td>
                                            <td>
                                                @php
                                                    $names = '';
                                                    $ndata = json_decode($data->malik_name);
                                                    $ndata = !blank($ndata) ? $ndata : array();
                                                    foreach ($ndata as $n) {
                                                        $names .= "$n->name, ";
                                                    }
                                                @endphp
                                                {{ rtrim($names, ', ') }}
                                            </td>
                                            <td><span class="badge badge-light border text-muted">{{ $data->sl_no }}</span></td>
                                            <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('user.land.print', $data->uid) }}" class="btn btn-sm btn-outline-primary mr-1" target="_blank" title="প্রিন্ট">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="{{ route('user.land.update', $data->uid) }}" class="btn btn-sm btn-outline-warning mr-1" title="সম্পাদনা">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('user.land.delete', $data->uid) }}" method="post" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Do you really want to delete this?');" title="মুছুন">
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
        $(document).on('click', '.recharge', function () {
        });
    </script>
@endpush
