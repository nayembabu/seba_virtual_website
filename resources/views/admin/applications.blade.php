@extends('admin.layouts.app')
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
            
            <form action="">
                    <div class="row">
                    <div class="col-md-6">
                        <input type="text" value="{{ $request->q }}" name="q" placeholder="Type ID No, Name, Type etc" class="form-control" />
                    </div>
                    
                    
                    <div class="col-md-6">
                       <button class="btn btn-success">Search</button>
                    </div>
                    
                    </div>
                </form>
            
              
               <br/>
          
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                       
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('ID No')</th>
                        <th scope="col">@lang('Name')</th>
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
                            <td data-label="@lang('Name')">
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
                                
                                @if ( $application->status == '3' )
                                <b style="color:red">Cancelled ( {{ $application->cancel_reason }} )</b>
                                @endif
                                
                                 @if ( $application->status == '1' )
                                <b style="color:green">Delivered by : {{@$application->mod->username}}</b>
                                <br/>
                                 <a class="btn btn-info btn-sm" target="_blank" href="{{ url('storage/uploads/'.$application->file) }}">View File</a>
                                @endif
                                
                                
                                 @if ( $application->status == '2' )
                                <b style="color:purple">Accepted By : {{@$application->mod->username}} </b>
                                @endif
                                
                            </td>
                           
                            <td data-label="@lang('Date')">
                                {{ date('d F Y',strtotime(@$application->created_at)) }}
                            </td>
                          
                            
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
                                
                                
                                @if ( $application->type == 'Advanced' )
                                <a data-info='{!! $application->extra !!}' href='javascript:void(0);' class='view-info btn btn-info'> <i class="fas fa-eye"></i> View Info </a>
                                 @endif
                                
                                <form action="{{ route('applications.makePending', ['id' => $application->id]) }}" method="POST">
    @csrf
    @method('POST')
    <button type="submit"class="btn btn-primary"><i class="fas fa-hourglass-half"></i> Make Pending</button>
</form>


                                <form style="display:inline-block
                                        " action="{{ route('admin.delete-application',$application->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this application?');">
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
                {{$applications->appends(@$_GET)->links('partials.pagination')}}
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

   <div class="modal fade" id="m-info" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Application Info')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <div id="info-html"></div>
                </div>
            </div>
        </div>
    </div>
    

@endsection


@push('js')
    <script>
        
         $(document).on('click', '.view-info', function () {
            let data = $(this).attr('data-info');
            const obj = JSON.parse(data);
            let html = '<label>ভোটারের ছবিঃ </label><br/><img src="{{ url('storage/photos') }}/'+obj.photo+'" style="width:100px" /><br/>';
            html += '<br/> <label>নিজের নামঃ '+obj.name+'</label>';
            html += '<br/> <label>পিতার নামঃ '+obj.father_name+'</label>';
            html += '<br/> <label>মাতার নামঃ '+obj.mother_name+'</label>';
            html += '<br/> <label>স্বামী বা স্ত্রীর নামঃ  '+obj.spouse_name+'</label>';
            html += '<br/> <label>বিভাগঃ '+obj.division+'</label>';
            html += '<br/> <label>জেলাঃ  '+obj.district+' </label>';
            html += '<br/> <label>থানাঃ     '+obj.thana+' </label>';
            html += '<br/> <label>সিটি/পৌরসভা বা ইউনিয়নঃ   '+obj.up+'</label>';
            html += '<br/> <label>ওয়ার্ড নংঃ '+obj.up+'  </label>';
            html += '<br/> <label>গ্রামের নামঃ '+obj.village+' </label>';
            html += '<br/> <label>মৌজা মহল্লার নামঃ   '+obj.mouza+' </label>';
            html += '<br/> <label>সাথের ভোটার আইডিঃ   '+obj.s_nid +'</label>';
            html += '<br/> <label>বাবার ভোটার আইডিঃ   '+obj.father_nid+' </label>';
            html += '<br/> <label>মায়ের ভোটার আইডিঃ  '+obj.mother_nid+'</label>';
            $('#info-html').html(html);
            $('#m-info').modal('show');
        });
         $(document).on('click', '.more-details', function () {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $('#ht').html('');
            $('#status-ch').modal('show');
        });
    </script>
@endpush