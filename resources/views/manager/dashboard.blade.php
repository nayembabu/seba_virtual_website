@extends('manager.layouts.app')
@section('title')
    @lang('Dashboard')
@endsection
@section('content')

    <div class="container-fluid">
        
        <div class="row">

         
             <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <a href="{{ route('manager.moderators') }}">
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{number_format($mods)}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Total Moderators')
                                </h6>
                                </a>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
             <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <a href="{{ route('manager.users') }}">
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{number_format($users)}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Total Users')
                                </h6>
                                </a>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-file"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           
            

        </div>


    </div>



@endsection

@push('js')

  
@endpush
