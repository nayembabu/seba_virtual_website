@extends('admin.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')

    <div class="container-fluid">
        
         <form action="">
        <div class="row">
           
            <div class="col-md-6">
                <input name="date" class="form-control" type="date" value="{{ $date }}" />
            </div>
            
            <div class="col-md-6">
                <button class="btn btn-success">Search</button>
            </div>
           
        </div>
        </form>
        
        <br/>
        
        
        <div class="row">
        
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                               
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"> {{ $today_total }} </h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Today Total Application')
                                </h6>
                               
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"> <i class="fa fa-file"></i></span>
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
                               
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"> {{ $today_accepted }} </h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Today Accepted Application')
                                </h6>
                               
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"> <i class="fa fa-file"></i></span>
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
                               
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"> {{ $today_delivered }} </h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Today Delivered Application')
                                </h6>
                               
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"> <i class="fa fa-file"></i></span>
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
                               
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"> {{ $total }} </h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Total Application')
                                </h6>
                               
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"> <i class="fa fa-file"></i></span>
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
                               
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"> {{ $accepted }} </h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Total Accepted Application')
                                </h6>
                               
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"> <i class="fa fa-file"></i></span>
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
                               
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium"> {{ $delivered }} </h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Total Delivered Application')
                                </h6>
                               
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"> <i class="fa fa-file"></i></span>
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
