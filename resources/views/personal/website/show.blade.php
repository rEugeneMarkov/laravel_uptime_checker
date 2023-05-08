@extends('layouts.personal')

@section('content')
    <div class="container-fluid d-flex justify-content-start">
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
                <a class="btn btn-success ml-3 disabled" href="{{ route('personal.website.activate', $website->id) }}"
                    role="button">Check</a>
                @if (!$website->monitoring_status)
                    <a class="btn btn-warning ml-3" href="{{ route('personal.website.activate', $website->id) }}"
                        role="button">Activate</a>
                @else
                    <a class="btn btn-warning ml-3" href="{{ route('personal.website.activate', $website->id) }}"
                        role="button">Deactivate</a>
                @endif

                <a class="btn btn-success ml-3" href="{{ route('personal.website.edit', $website->id) }}"
                    role="button">Edit</a>
                <form action="{{ route('personal.website.destroy', $website->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger ml-3">Delete</button>
                </form>
            </div>
        </div>
        @if ($avg_execution_time > 0)
            <div class="col-6 bg-dark" style="border-radius: 5px">
                <div>
                    <div class="mt-4 text-white">
                        <b style="font-size: 24px">Response Time</b> 
                        <span style="color: lightgreen">last 24 hours ({{ number_format($avg_execution_time, 2) }}ms av.)</span>
                        <p style="font-size: 12px" class="mt-2">Shows the "instant" that the monitor started returning a
                            response in ms
                            (and
                            average for the displayed
                            period is {{ number_format($avg_execution_time, 2) }}ms).</p>
                    </div>
                    <div class="mt-3 mb-3">
                        <canvas id="myChart" class="w-100 h-50"></canvas>
                    </div>
                </div>
            </div>
        @endif

    </div>
    {{-- <div>
        <div>
            <table>
                <tr>
                    <td>
                        <a class="btn btn-success disabled"
                            href="{{ route('personal.website.activate', $website->id) }}" role="button">Check</a>
                    </td>
                    @if (!$website->monitoring_status)
                        <td>
                            <a class="btn btn-warning" href="{{ route('personal.website.activate', $website->id) }}"
                                role="button">Activate</a>
                        </td>
                    @else
                        <td>
                            <a class="btn btn-warning" href="{{ route('personal.website.activate', $website->id) }}"
                                role="button">Deactivate</a>
                        </td>
                    @endif

                    <td>
                        <a class="btn btn-success" href="{{ route('personal.website.edit', $website->id) }}"
                            role="button">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('personal.website.destroy', $website->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        <br>
    </div> --}}
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        Chart.defaults.color = "white";
        var chartData = <?php echo json_encode($chartData); ?>;
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(item => item[0] + ':00'),
                datasets: [{
                    label: 'Response Time',
                    data: chartData.map(item => item[1]),
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
