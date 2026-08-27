@extends('admin.layouts.app')
@section('title')
    @lang("User Transactions")
@endsection
@section('content')
    <style>
        .fa-ellipsis-v:before {
            content: "\f142";
        }
    </style>
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
        
            <!-- Search Form -->
            <form action="{{ route('admin.transactions') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="trx_id" class="form-control" placeholder="@lang('Search by TX ID')" value="{{ request()->trx_id }}">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="email" class="form-control" placeholder="@lang('Search by Email')" value="{{ request()->email }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-block">@lang('Search')</button>
                    </div>
                </div>
            </form>

            <br/>
          
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">@lang('No.')</th>
                    <th scope="col">@lang('User')</th>
                    <th scope="col">@lang('Email')</th>
                    <th scope="col">@lang('Amount')</th>
                    <th scope="col">@lang('Details')</th>
                    <th scope="col">@lang('Type')</th>
                    <th scope="col">@lang('TX ID')</th>
                    <th scope="col">@lang('Date')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $key => $transaction)
                    <tr>
                        <td data-label="@lang('No.')">{{ $key + 1 }}</td>
                        <td data-label="@lang('User')">{{ @$transaction->user->name }}</td>
                        <td data-label="@lang('Email')">{{ @$transaction->user->email }}</td>
                        <td data-label="@lang('Amount')">{{ $transaction->amount }}</td>
                        <td data-label="@lang('Details')">{{ $transaction->details }}</td>
                        <td data-label="@lang('Type')">
                            @if($transaction->type == '+')
                                <b style="color:green">Credit</b>
                            @else
                                <b style="color:red">Debit</b>
                            @endif
                        </td>
                        <td data-label="@lang('TX ID')">{{ $transaction->tx_id }}</td>
                        <td data-label="@lang('Date & Time')">{{ date('d F Y h:i A', strtotime(@$transaction->created_at)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-danger" colspan="8">@lang('No Data')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $transactions->appends(@$_GET)->links('partials.pagination') }}
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
