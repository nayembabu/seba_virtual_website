@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
    
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body bn-layout">
            
            
         
               <div class="text-right">
                <a href="{{route('user.nidmanuall.create')}}" class="btn btn-success"> <i class="fas fa-plus"></i> কর দিন </a>
               </div>
               
              
                 <div style="overflow-x:auto;">
                <table class="categories-show-table table table-hover table-striped table-bordered" >
                    <thead class="thead-dark">
                    <tr>
                       
                        <th scope="col">@lang('আইডি')</th>
                        <th scope="col">@lang('সিটি/পৌর/ইউনিয়ন নাম')</th>
                        <th scope="col">@lang('মালিক')</th>
                        <th scope="col">@lang('ক্রমিক নং')</th>
                        <th scope="col">@lang('তারিখ')</th>
                        <th scope="col" style="text-align:center">@lang('অ্যাকশান')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($objects as $key=> $data)
                        <tr>
                            
                            <td data-label="@lang('আইডি')<">
                                {{ $key + 1 }}
                                </td>
                            <td data-label="@lang('সিটি/পৌর/ইউনিয়ন নাম')">
                               {{ $data->office_name }}
                            </td>
                            <td data-label="@lang('মালিক')">
                            @php
                            $names = '';
                            $ndata = json_decode($data->malik_name);
                            $ndata = !blank($ndata) ? $ndata : array();
                            foreach( $ndata as $n ){
                            $names .= "$n->name, ";
                            }
                            @endphp
                               {{ $names }}
                            </td>
                            <td data-label="@lang('ক্রমিক নং')">
                               {{ $data->sl_no }}
                            </td>
                            
                           <td data-label="@lang('তারিখ')">
                              {{ date('d F Y', strtotime($data->created_at)) }}
                            </td>
                          
                            
                            <td data-label="@lang('অ্যাকশান')" class="text-lg-center text-right">
                                
                             <a href="{{ route('user.nidmanuall.print',$data->id) }}" class="btn btn-primary" target="_blank"> <i class="fas fa-print"></i> </a>
                              <a href="{{ route('user.nidmanuall.update', $data->id)}}" class="btn btn-info"> <i class="fas fa-pencil-alt"> </i></a>
                                
                                <form style="display:inline-block
                                        " action="{{ route('user.nidmanuall.delete',$data->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this?');">
                                          @csrf 
                                         <button class="btn btn-danger"> <i class="fas fa-trash"></i>
                                         </button>
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