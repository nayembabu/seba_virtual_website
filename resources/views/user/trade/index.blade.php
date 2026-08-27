@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-id-badge mr-2"></i> Trade License List
                        </h5>
                        <a href="{{route('user.trade.create')}}" class="btn btn-primary btn-sm px-4 shadow-sm">
                            <i class="fas fa-plus-circle mr-1"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover datatable dt-responsive nowrap w-100">
                                <thead class="thead-light">
                                    <tr>
                                        <th>@lang('No.')</th>
                                        <th>@lang('Bussiness Name')</th>
                                        <th>@lang('Nid No')</th>
                                        <th>@lang('Certificate')</th>
                                        <th>@lang('Verify')</th>
                                        <th>@lang('Date')</th>
                                        <th class="text-center">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($objects as $key=> $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="font-weight-medium text-dark">{{ $data->b_name }}</td>
                                            <td>{{ $data->nid_no }}</td>
                                            <td>
                                                <a href="{{ route('user.trade.print',$data->id) }}" class="btn btn-sm btn-outline-primary" target="_blank"> 
                                                    <i class="fas fa-print mr-1"></i> Print
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.trade.verify',$data->id) }}" class="btn btn-sm btn-outline-success" target="_blank"> 
                                                    <i class="fas fa-check-circle mr-1"></i> Verify
                                                </a>
                                            </td>
                                            <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('user.trade.update', $data->id)}}" class="btn btn-sm btn-outline-warning mr-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('user.trade.delete',$data->id) }}" method="post" class="d-inline">
                                                        @csrf 
                                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Do you really want to delete this?');" title="Delete">
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