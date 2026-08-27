@extends('mod.layouts.app')
@section('title')
    @lang("Application List")
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
          
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                       
                        <th scope="col">@lang('No.')</th>
                         <th scope="col">@lang('ID No')</th>
                          <th scope="col">@lang('name')</th>
                        <th scope="col">@lang('Type')</th>
                        <th scope="col">@lang('User')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Date')</th>
                        <th scope="col" style="text-align:center">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($applications as $key=> $application)
                        <tr>
                            
                            <td data-label="@lang('No.')">
                                {{ $key + 1 }}
                                </td>
                           <td data-label="@lang('ID No')">
                                {{ $application->nid }}
                                
                            </td>
                            <td data-label="@lang('name')">
                                {{ $application->name }}
                                
                            </td>
                            <td data-label="@lang('Type')">
                                {{ $application->type }}
                            </td>
                            <td data-label="@lang('user')">
                                {{ @$application->user->name }}
                            </td>
                            <td data-label="@lang('Status')">
                                
                                @if ( $application->status == '0' )
                                <b style="color:red">Pending</b>
                                @endif
                                
                                @if ( $application->status == '2' )
                                <b style="color:purple">Accepted</b>
                                @endif
                                
                                @if ( $application->status == '4' )
                                <b style="color:blue">Waiting for Confirmation</b>
                                @endif
                                
                                @if ( $application->status == '5' )
                                <b style="color:green">Confirmed</b>
                                @endif
                                
                                
                                @if ( $application->status == '1' )
                                <b style="color:green">Delivered</b><br/>
                                 <a class="btn btn-info btn-sm" target="_blank" href="{{ url('storage/uploads/'.$application->file) }}">View File</a>
                                 <a href="javascript:void(0);" class="btn btn-warning btn-sm change" data-id="{{ $application->id }}">Change File</a>
                                @endif
                              
                                
                            </td>
                           
                          <td data-label="@lang('Date')">
                                {{ date('d F Y',strtotime(@$application->created_at)) }}
                            </td>
                            
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
                                @if ( $application->status == '2' && $application->type !== 'Advanced')
                                        
                                         <a data-id="{{ $application->id }}" href="javascript:void(0);" class="deliver btn btn-success"> <i class="fas fa-check"></i> Upload File & Deliver </a>
                                         
                                         <a data-id="{{ $application->id }}" href="javascript:void(0);" class="cancel btn btn-danger"> <i class="fas fa-times"></i> Cancel </a>
                               
                                 @endif
                                 
                                 @if ( $application->type == 'Advanced' )
                                 
                                 
                                 @if ( $application->status == '2'  )
                                  <a data-id="{{ $application->id }}" href="javascript:void(0);" class="photo btn btn-success"> <i class="fas fa-photos"></i> Upload Photo </a>
                                   <a data-id="{{ $application->id }}" href="javascript:void(0);" class="cancel btn btn-danger"> <i class="fas fa-times"></i> Cancel </a>
                                 @endif
                                 
                                  @if ( $application->status == '5'  )
                                         <a data-id="{{ $application->id }}" href="javascript:void(0);" class="deliver btn btn-success"> <i class="fas fa-check"></i> Upload File & Deliver </a>
                                          <a data-id="{{ $application->id }}" href="javascript:void(0);" class="cancel btn btn-danger"> <i class="fas fa-times"></i> Cancel </a>
                                 @endif
                                 
                                 
                                <a data-info='{!! $application->extra !!}' href='javascript:void(0);' class='view-info btn btn-info'> <i class="fas fa-eye"></i> View Info </a>
                                 @endif
                                 
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="9">@lang('No Data')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$applications->appends(@$_GET)->links('partials.pagination')}}
            </div>
        </div>
    </div>
    
    
    
    <div class="modal fade" id="status-ch" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Deliver Appliccation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('mod.deliver-application') }}" enctype="multipart/form-data">
                        <input name="id" value="" type="hidden" id="uid" />
                        <label>File</label>
                        <input class="form-control" type="file" name="file" required /><br/>
                        <button class="btn btn-success">Deliver</button>
                        @csrf
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="status-change" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Change Application File')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('mod.redeliver-application') }}" enctype="multipart/form-data">
                        <input name="id" value="" type="hidden" id="uidc" />
                        <label>File</label>
                        <input class="form-control" type="file" name="file" required /><br/>
                        <button class="btn btn-success">Change</button>
                        @csrf
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="cancel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Cancel Application')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('mod.cancel-application') }}" enctype="multipart/form-data">
                    <input name="id" value="" type="hidden" id="cid" />
                    <label for="cancel_reason">Cancel Reason</label>
                    <select class="form-control" name="cancel_reason" id="cancel_reason" required>
                        <option value="">Select a reason</option>
                        <option value="Not ready">Not ready</option>
                        <option value="Match Found">Match Found</option>
                        <option value="Doubble Voter">Doubble Voter</option>
                        <option value="Lock">Lock</option>
                        <option value="No Data">No Data</option>
                        <option value="নামের সাথে মিল নাই">নামের সাথে মিল নাই</option>
                        <option value="ইউজার পাস ভুল"> ইউজার পাস ভুল</option>
                        <option value="আজকের সময় শেষ দয়া করে কাল আবার দেন ">আজকের সময় শেষ দয়া করে কাল আবার দেন ">No </option>
                    </select>
                    <button class="btn btn-danger">Cancel</button>
                    @csrf
                </form>
                   
                </div>
            </div>
        </div>
    </div>
    
    
   
    
     

    

@endsection


@push('js')
    <script>
        
         $(document).on('click', '.deliver', function () {
            var id = $(this).attr('data-id');
            $('#uid').val(id);
            $('#status-ch').modal('show');
        });
        
         $(document).on('click', '.photo', function () {
            var id = $(this).attr('data-id');
            $('#fid').val(id);
            $('#photo-m').modal('show');
        });
        
         $(document).on('click', '.change', function () {
            var id = $(this).attr('data-id');
            $('#uidc').val(id);
            $('#status-change').modal('show');
        });
        
        $(document).on('click', '.cancel', function () {
            var id = $(this).attr('data-id');
            $('#cid').val(id);
            $('#cancel').modal('show');
        });
        
    </script>
@endpush