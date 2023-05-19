@extends('layouts.personal')
<style>
    .uptimeChart ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
        margin-top: 12px;
    }

    .uptimeChart li {
        opacity: .8;
        display: inline-block;
        height: 20px;
        float: right;
    }
</style>
@section('content')
    <div class="container-fluid d-flex justify-content-center">
        <div class="col-6">
            <table class="table table-bordered border-{{ !$website->monitoring_status ? 'danger' : 'success' }}">
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td>{{ $website->id }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Friendly Name</th>
                        <td>{{ $website->title }}</td>
                    </tr>
                    <tr>
                        <th scope="row">URL (or IP)</th>
                        <td>{{ $website->website }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Monitoring Interval</th>
                        <td>{{ $website->interval }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Monitoring Timeout</th>
                        <td>{{ $website->timeout }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Check count</th>
                        <td>{{ $website->checkData->count() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td class="bg-{{ !$website->monitoring_status ? 'danger' : 'success' }} text-white">
                            {{ $website->monitoring_status ? 'Enabled' : 'Disabled' }} </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-start">
                <a class="btn btn-success ml-3" href="{{ route('personal.manualcheck', $website->id) }}"
                    role="button">Check</a>
                <a class="btn btn-warning ml-3" href="{{ route('personal.website.activate', $website->id) }}"
                    role="button">{{ !$website->monitoring_status ? 'Activate' : 'Deactivate' }}</a>
                <a class="btn btn-success ml-3" href="{{ route('personal.website.edit', $website->id) }}"
                    role="button">Edit</a>
                <form action="{{ route('personal.website.destroy', $website->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger ml-3">Delete</button>
                </form>
            </div>
        </div>
        @if ($avgExecTime > 0)
            <div class="col-6 bg-dark text-white" style="border-radius: 5px">
                <div>
                    <b style="font-size: 36px">Uptime</b>
                    <span style="color: lightgreen">last 24 hours</span>
                </div>
                <div style="margin-right: 40px">
                    <ul class="uptimeChart">
                        @foreach ($uptimeChartData as $data)
                            <li data-tooltip="tooltip"
                                title="Start Time: {{ $data['start_time']->format('Y-m-d H:i:s') }} &#013;End Time: {{ $data['end_time']->format('Y-m-d H:i:s') }}&#013;Duration: {{ floor($data['duration'] / 60) }} hrs, {{ $data['duration'] % 60 }} mins&#013;Status: {{ $data['status'] }}"
                                style="width: {{ $data['duration'] / 1440 * 100 }}%; background: {{ $data['status'] == 'Down' ? '#ba3737' : '#4da74d' }};">
                                <img src="/img/1px.gif" alt="1px">
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <div class="mt-4">
                        <b style="font-size: 36px">Response Time</b>
                        <span style="color: lightgreen; font-size: 24px">last 24 hours ({{ number_format($avgExecTime, 2) }}ms
                            av.)</span>
                        <p style="font-size: 12px" class="mt-2">Shows the "instant" that the monitor started returning a
                            response in ms (and average for the displayed period is {{ number_format($avgExecTime, 2) }}ms).
                        </p>
                    </div>
                    <div class="mt-3 mb-3">
                        <canvas id="myChart" class="w-100 h-50"></canvas>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        Chart.defaults.color = "white";
        var chartData = <?php echo json_encode($dashChartData); ?>;
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(item => item['hour'] + ':00'),
                datasets: [{
                    label: 'Response Time',
                    data: chartData.map(item => item['avg_execution_time']),
                    borderColor: 'rgb(0, 201, 87)',
                    backgroundColor: 'rgba(0, 201, 87, 0.2)',
                    fontColor: 'rgb(0, 201, 87)',
                    fill: true
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 6
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    </script>
@endsection
