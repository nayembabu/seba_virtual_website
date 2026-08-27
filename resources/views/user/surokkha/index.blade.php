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
                            <i class="fas fa-shield-virus mr-2"></i> Vaccine Entry List
                        </h5>
                        <a href="{{route('user.surokkha.create')}}" class="btn btn-primary btn-sm px-4 shadow-sm">
                            <i class="fas fa-plus-circle mr-1"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover datatable dt-responsive nowrap w-100">
                                <thead class="thead-light">
                                    <tr>
                                        <th>@lang('No.')</th>
                                        <th>@lang('Name')</th>
                                        <th>@lang('Date of Birth')</th>
                                        <th>@lang('Nationality')</th>
                                        <th>@lang('Gender')</th>
                                        <th class="text-center">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($objects as $key=> $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="font-weight-medium text-dark">{{ $data->name }}</td>
                                            <td>{{ $data->date_birth }}</td>
                                            <td>{{ $data->nationality }}</td>
                                            <td><span class="badge badge-secondary">{{ $data->gender }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('user.surokkha.print',$data->id) }}" class="btn btn-sm btn-outline-primary mr-1" target="_blank" title="Download">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="{{ route('user.surokkha.edit', $data->id)}}" class="btn btn-sm btn-outline-warning mr-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('user.surokkha.destroy',$data->id) }}" method="post" class="d-inline">
                                                        @csrf 
                                                        @method('DELETE')
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