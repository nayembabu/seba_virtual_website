@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
    
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            
            
         
               <div class="text-right">
                <a href="{{route('user.police.create')}}" class="btn btn-success"> <i class="fas fa-plus"></i> Add Certificate </a>
               </div>
               
                 <div style="overflow-x:auto;">
                <table class="categories-show-table table table-hover table-striped table-bordered" >
                    <thead class="thead-dark">
                    <tr>
                       
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('Full Name')</th>
                        <th scope="col">@lang('REF No')</th>
                        <th scope="col">@lang('Certificate')</th>
                        <th scope="col">@lang('Verify')</th>
                        <th scope="col">@lang('Date')</th>
                        <th scope="col" style="text-align:center">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($objects as $key=> $data)
                        <tr>
                            
                            <td data-label="@lang('No.')">
                                {{ $key + 1 }}
                                </td>
                            <td data-label="@lang('Full Name')">
                               {{ $data->applicant_name }}
                            </td>
                            <td data-label="@lang('REF No')">
                               {{ $data->police_reg }}
                            </td>
                            <td data-label="@lang('Certificate')">
                             <a href="{{ route('user.police.print',$data->id) }}" class="btn btn-primary" target="_blank"> <i class="fas fa-print"></i> Print</a>
                            </td>
                            <td data-label="@lang('Verify')">
                             <a href="{{ route('user.police.verify',$data->id) }}" class="btn btn-success" target="_blank"> <i class="fas fa-check"></i> Verify</a>
                            </td>
                           
                           <td data-label="@lang('Date')">
                              {{ date('d F Y', strtotime($data->created_at)) }}
                            </td>
                          
                            
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
        
                              <a href="{{ route('user.police.update', $data->id)}}" class="btn btn-info"> <i class="fas fa-pencil-alt"> </i> Edit </a>
                                
                                <form style="display:inline-block
                                        " action="{{ route('user.police.delete',$data->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this?');">
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
                 </div>
                
                {{$objects->appends(@$_GET)->links('partials.pagination')}}
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