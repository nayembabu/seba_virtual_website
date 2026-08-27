@extends('admin.layouts.app')
@section('title')
    Usage History
@endsection

@section('content')
<div class="container">
    <h2>Transaction Usage History</h2>

    <h3>Last 24 Hours</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Transaction Type</th>
                <th>Usage Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($last24Hours as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ $transaction->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Last Week</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Transaction Type</th>
                <th>Usage Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lastWeek as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ $transaction->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Last Month</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Transaction Type</th>
                <th>Usage Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lastMonth as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ $transaction->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
