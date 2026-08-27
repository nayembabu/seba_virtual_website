@extends('admin.layouts.app')
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
            
            <form action="">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" value="{{ $request->q }}" name="q" placeholder="Type Name, Phone, Email etc" class="form-control" />
                    </div>
                    <div class="col-md-6">
                       <button class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>
            <br/>
            
            <div class="text-right">
                <form style="display:inline-block" action="{{ route('admin.delete-inactive-users') }}" method="post" onsubmit="return confirm('Do you really want to do this?');">
                    @csrf 
                    <button class="btn btn-danger"><i class="fas fa-trash"></i> Delete Inactive Users</button>
                </form><br/>
            </div>
            
            <div style="overflow-x:auto;">
                <table class="categories-show-table table table-hover table-striped table-bordered">
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
                            <td data-label="@lang('No.')">{{ $key + 1 }}</td>
                            <td data-label="@lang('Name')">{{ $user->name }}</td>
                            <td data-label="@lang('Phone')">{{ $user->phone }}</td>
                            <td data-label="@lang('Email')">{{ $user->email }}</td>
                            <td data-label="@lang('Balance')">{{ inum($user->balance) }}</td>
                           
                           <td data-label="@lang('Status')">
                               @if ($user->status == '0')
                                <b style="color:red">Banned</b>
                                <form style="display:inline-block" action="{{ route('admin.unban-user',$user->id) }}" method="post" onsubmit="return confirm('Do you really want to unban this user?');">
                                    @csrf 
                                    <button class="btn btn-success"><i class="fas fa-check"></i> Unban User</button>
                                </form>
                               @else
                                <b style="color:green">Active</b>
                                <form style="display:inline-block" action="{{ route('admin.ban-user',$user->id) }}" method="post" onsubmit="return confirm('Do you really want to ban this user?');">
                                    @csrf 
                                    <button class="btn btn-danger"><i class="fas fa-times"></i> Ban User</button>
                                </form>
                               @endif
                            </td>
                            
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
                                <a href="{{ route('admin.user-edit',$user->id) }}" class="btn btn-info"><i class="fas fa-pencil-alt"></i> Edit</a>
                                <a href="javascript:void(0);" data-name="{{ $user->name }}" data-id="{{ $user->id }}" class="recharge btn btn-success"><i class="fas fa-wallet"></i> Wallet</a>
                                
                                @if ($user->status == '1')
                                <form target="_blank" style="display:inline-block" action="{{ route('admin.login-as-user',encrypt($user->id)) }}" method="post">
                                    @csrf 
                                    <button class="btn btn-secondary"><i class="fas fa-lock"></i> Login As User</button>
                                </form>
                                @endif
                                
                                <form style="display:inline-block" action="{{ route('admin.user-delete',$user->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this user?');">
                                    @csrf 
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                                
                                <!-- Password Reset Button -->
                                <form action="{{ route('admin.reset-password', $user->id) }}" method="post" onsubmit="return confirm('Do you really want to reset this user\'s password?');">
    @csrf
    <button class="btn btn-warning"> <i class="fas fa-key"></i> Reset Password </button>
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
            
            {{ $users->appends(@$_GET)->links('partials.pagination') }}
        </div>
    </div>
    
    <!-- Wallet Modal -->
    <div class="modal fade" id="status-ch" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Wallet ') of <span id="uname"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.user-recharge') }}">
                        @csrf
                        <input id="uid" name="id" type="hidden" />
                        <label>Amount</label>
                        <input name="amount" type="number" class="form-control" required />
                        <input name="type" type="submit" class="btn btn-success" value="Recharge" />
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
