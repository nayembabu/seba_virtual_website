@extends('admin.layouts.app')
@section('title')
    @lang("Notification History")
@endsection
@section('content')
    <style>
        .fa-ellipsis-v:before {
            content: "\f142";
        }
    </style>
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
        
             <div class="text-right">
                     <a class="btn btn-info" href="{{ route('admin.send-notification') }}">
                         <i class="fas fa-bell"> </i> Send Notification
                     </a>
               </div>
               
               
               
               <br/>
          
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                       
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('To')</th>
                        <th scope="col">@lang('Message')</th>
                        <th scope="col">@lang('Date')</th>
                        <th scope="col" style="text-align:center">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($notifications as $key=> $notification)
                        <tr>
                            
                            <td data-label="@lang('No.')">
                                {{ $key + 1 }}
                                </td>
                            <td data-label="@lang('Type')">
                                
                                @if ( blank($notification->user_id) ) 
                                All
                                @else
                                {{ @$notification->user->email }}
                                @endif
                                
                            </td>
                             <td data-label="@lang('Message')">
                                {{ @$notification->msg }}
                            </td>
                            
                            <td data-label="@lang('Date')">
                                {{ date('d F Y',strtotime(@$notification->created_at)) }}
                            </td>
                          
                            
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
        

                                <form style="display:inline-block
                                        " action="{{ route('admin.delete-notification',$notification->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this notification?');">
                                          @csrf 
                                         <button class="btn btn-danger"> <i class="fas fa-trash"></i> Delete  </button>
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
                {{$notifications->appends(@$_GET)->links('partials.pagination')}}
            </div>
        </div>
    </div>
    
    
    
    <div class="modal fade" id="status-ch" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('More Details')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" ation="">
                        @csrf
                    </form>
                    <div id="ht"></div>
                </div>
            </div>
        </div>
    </div>

    

@endsection


@push('js')
    <script>
         $(document).on('click', '.more-details', function () {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $('#ht').html('');
            $('#status-ch').modal('show');
        });
    </script>
@endpush