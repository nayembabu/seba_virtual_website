@extends('admin.layouts.app')
@section('title')
    @lang("Moderators")
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
               
               <div class="float-right" style="float:right">
                   <a class="btn btn-success" href="{{ route('admin.add-moderator') }}">Add New+</a>
               </div>
          
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                       
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Username')</th>
                        <th scope="col">@lang('Phone')</th>
                        <th scope="col">@lang('Email')</th>
                        <th scope="col" style="text-align:center">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $key=> $user)
                        <tr>
                            
                            <td data-label="@lang('No.')">
                                {{ $key + 1 }}
                                </td>
                            <td data-label="@lang('Name')">
                                {{ $user->name }}
                            </td>
                             <td data-label="@lang('Username')">
                                {{ $user->username }}
                            </td>
                            <td data-label="@lang('Phone')">
                                {{ $user->phone }}
                            </td>
                            <td data-label="@lang('Email')">
                                {{ $user->email }}
                            </td>
                           
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
        
                                <a href="{{ route('admin.edit-moderator',$user->id) }}" class="btn btn-info"> <i class="fas fa-pencil-alt"> </i> Edit </a>
                                
                                 <a href="{{ route('admin.moderator-reports',$user->id) }}" class="btn btn-success"> <i class="fas fa-file"> </i> Reports </a>
                             
                                <form style="display:inline-block
                                        " action="{{ route('admin.delete-moderator',$user->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this moderator?');">
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
                {{$users->appends(@$_GET)->links('partials.pagination')}}
            </div>
        </div>
    </div>
    
    
    
    

@endsection


@push('js')
    <script>
        
    </script>
@endpush