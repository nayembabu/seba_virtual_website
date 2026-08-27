@extends('user.layouts.app')
@section('title')
    @lang("User List")
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
              
                 <div style="overflow-x:auto;">
                <table class="categories-show-table table table-hover table-striped table-bordered" >
                    <thead class="thead-dark">
                    <tr>
                       
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Phone')</th>
                        <th scope="col">@lang('Email')</th>
                        <th scope="col">@lang('Balance')</th>
                        <th scope="col">@lang('Status')</th>
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
                            <td data-label="@lang('Phone')">
                                {{ $user->phone }}
                            </td>
                            <td data-label="@lang('Email')">
                                {{ $user->email }}
                            </td>
                            <td data-label="@lang('Balance')">
                                {{ inum($user->balance) }}
                            </td>
                           
                           <td data-label="@lang('Status')">
                                @if ( $user->status == '0' )
                                <b style="color:red">Banned</b>
                                @endif
                                
                                @if ( $user->status == '1' )
                                <b style="color:green"> Active </b>
                                @endif
                            </td>
                          
                            
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
                               
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
                
                {{$users->appends(@$_GET)->links('partials.pagination')}}
            </div>
        </div>
    </div>
    
    
    
    <div class="modal fade" id="status-ch" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                
                
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Wallet ') of <span id="uname"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('manager.user-subtract') }}">
                        @csrf
                        <input id="uid" name="id" type="hidden" />
                        <label>Amount</label>
                        <input name="amount" type="number" class="form-control" required />
                        <input name="type" type="submit" class="btn btn-danger" value="Subtract" />
                    </form>
                </div>
                
                
                
            </div>
        </div>
    </div>

    

@endsection


@push('js')
    <script>
         $(document).on('click', '.recharge', function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            $('#uid').val(id);
            $('#uname').html(name);
            $('#status-ch').modal('show');
        });
    </script>
@endpush