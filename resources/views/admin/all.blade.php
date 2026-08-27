@extends('manager.layouts.app')

@section('title')
    @lang($title)
@endsection

@section('content')

<div class="container-fluid">
    <form action="">
        <div class="row">
            <div class="col-md-6">
                <input name="date" class="form-control" type="date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-md-6">
                <button class="btn btn-success">Search</button>
            </div>
        </div>
    </form>

    <br/>

    <div class="row">
        <div class="col-md-12">
            <canvas id="moderatorChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('moderatorChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Today Total', 'Today Accepted', 'Today Delivered'],
                datasets: [
                    @foreach($moderatorsData as $moderator)
                    {
                        label: '{{ $moderator->name }}',
                        data: [{{ $moderator->today_total }}, {{ $moderator->today_accepted }}, {{ $moderator->today_delivered }}],
                        backgroundColor: 'rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, 0.5)',
                        borderColor: 'rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, 1)',
                        borderWidth: 1
                    },
                    @endforeach
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush
