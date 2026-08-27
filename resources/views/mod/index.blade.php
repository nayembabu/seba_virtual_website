@extends('mod.layouts.app')
@section('title')
    @lang('Home')
@endsection
@section('content')
    
    <div class="container-fluid">
        
       
        
        <div class="row">
            
            
            
           <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 class="text-dark mb-1 font-weight-medium">{{$a}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Accepted Applications')
                                </h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-file"></i></span>
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
                                
                                <a href="">
                                <div class="d-inline-flex align-items-center">
                                    <h2 style="color:blue! important" class="text-dark mb-1 font-weight-medium">{{$d}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Delivered Applications')
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
            <!-- New card for "Today Delivery" -->
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="card shadow border-right">
                    <div class="card-body">
                        <div class="d-flex d-lg-flex d-md-block align-items-center">
                            <div>
                                <div class="d-inline-flex align-items-center">
                                    <h2 style="color: green !important" class="text-dark mb-1 font-weight-medium">{{$today_delivery}}</h2>
                                </div>
                                <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">@lang('Today Delivery')</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted"><i class="fa fa-truck"></i></span>
                            </div>
                        </div>
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

@push('style')

@endpush