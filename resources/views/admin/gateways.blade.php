@extends('layouts.admin')
@section('title')
    @lang('Gateways')
@endsection
@section('content')
    <style>
        .fa-ellipsis-v:before {
            content: "\f142";
        }
    </style>
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <br/>
            <div class="float-right" style="float:right">
                <a class="btn btn-success" href="{{ route('admin.add-gateway') }}">Add New+</a>
            </div>
          
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Account')</th>
                        <th scope="col">@lang('Logo')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col" style="text-align:center">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gateways as $key => $gateway)
                        <tr>
                            <td data-label="@lang('No.')">{{ $key + 1 }}</td>
                            <td data-label="@lang('Name')">{{ $gateway->name }}</td>
                            <td data-label="@lang('Account')">{{ $gateway->account }}</td>
                            <td data-label="@lang('Logo')">
                                @if($gateway->logo)
                                    <img src="{{ url('storage/uploads/'.$gateway->logo) }}" style="width:50px" />
                                @else
                                    <span class="text-muted">No logo</span>
                                @endif
                            </td>
                            <td data-label="@lang('Status')">
                                @if($gateway->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
                                <a href="{{ route('admin.toggle-gateway',$gateway->id) }}" class="btn btn-{{ $gateway->status ? 'warning' : 'success' }}">
                                    <i class="fas fa-{{ $gateway->status ? 'pause' : 'play' }}"></i> 
                                    {{ $gateway->status ? 'Deactivate' : 'Activate' }}
                                </a>
                                <a href="{{ route('admin.edit-gateway',$gateway->id) }}" class="btn btn-info">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <form style="display:inline-block" action="{{ route('admin.delete-gateway',$gateway->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this gateway?');">
                                    @csrf
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="9">@lang('No Data')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{$gateways->appends(@$_GET)->links('partials.pagination')}}
        </div>
    </div>
@endsection
