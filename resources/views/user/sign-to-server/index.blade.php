@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
    
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            
            
         
               <div class="text-right">
                <a href="{{route('user.sign-to-server.create')}}" class="btn btn-success"> <i class="fas fa-plus uppercase "></i> CREATE NEW ENTRY </a>
               </div>
               
                 <div style="overflow-x:auto;">
                <table class="categories-show-table table table-hover table-striped table-bordered" >
                    <thead class="thead-dark">
                     <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name (Bangla)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name (English)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                    </thead>
                    <tbody>
                    @forelse($objects as $key=> $data)
                        <tr>


                            <td data-label="@lang('Photo')" class="text-center">
                                @if(!empty($data->photo))
                                    @php
                                        $photoPath = $data->photo;
                                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath)) {
                                            try {
                                                $photoContents = \Illuminate\Support\Facades\Storage::disk('public')->get($photoPath);
                                                $mime = finfo_buffer(finfo_open(), $photoContents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                                                $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode($photoContents);
                                            } catch (\Exception $e) {
                                                $photoBase64 = null;
                                            }
                                        }
                                    @endphp
                                    @if(!empty($photoBase64))
                                        <img src="{{ $photoBase64 }}" alt="Photo" class="img-thumbnail" style="max-width:60px;max-height:60px;">
                                    @else
                                        <img src="{{ asset('storage/' . $data->photo) }}" alt="Photo" class="img-thumbnail" style="max-width:60px;max-height:60px;">
                                    @endif
                                @else
                                    <div class="img-thumbnail" style="width:60px;height:60px;display:inline-block;background:#f5f5f5;"></div>
                                @endif
                            </td>

                            <td data-label="@lang('ID Number')">
                               {{ $data->id_number ?? '' }}
                            </td>

                            <td data-label="@lang('Name (Bangla)')">
                               {{ $data->name_bangla ?? '' }}
                            </td>

                            <td data-label="@lang('Name (English)')">
                             {{ $data->name_english ?? '' }}
                            </td>

                            <td data-label="@lang('Phone')">
                                {{ $data->phone ?? '' }}
                            </td>
                         
                            
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
        
                                          <a href="{{ route('user.sign-to-server.show-v1',$data->id) }}" class="btn btn-primary" target="_blank">V1</a>
                                            <a href="{{ route('user.sign-to-server.show-v2',$data->id) }}" class="btn btn-primary" target="_blank">V2</a>
                                            <a href="{{ route('user.sign-to-server.show-v3',$data->id) }}" class="btn btn-primary" target="_blank">V3</a>
                               
                                        <a href="{{ route('user.sign-to-server.edit', $data->id) }}" class="btn btn-info"> Edit </a>
                                
                                                                <form style="display:inline-block" action="{{ route('user.sign-to-server.destroy',$data->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this?');">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                 <button class="btn btn-danger"> Delete  </button>
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