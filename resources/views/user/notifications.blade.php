@extends('user.layouts.app')
@section('title')
    @lang("Notifications")
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
                      
                        <th scope="col">@lang('Message')</th>
                        <th scope="col">@lang('Time')</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($notifications as $key=> $notification)
                        <tr>
                            
                         
                             <td data-label="@lang('Message')">
                                {{ @$notification->msg }}
                            </td>
                            
                            <td data-label="@lang('Time')">
                                {{ date('d F Y, h:i A',strtotime(@$notification->created_at)) }}
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