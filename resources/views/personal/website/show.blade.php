@extends('layouts.personal')

@section('content')
    <div class="container">
        <div class="col-6">
            <table class="table table-bordered border-{{ $website->status === 'Disabled' ? 'danger' : 'success' }}">
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
                        <th scope="row">Status</th>
                        <td class="bg-{{ !$website->monitoring_status ? 'danger' : 'success' }}">
                            {{ $website->monitoring_status ? 'Enabled' : 'Disabled'}} </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tr>
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
        <div>
            <canvas id="myChart" class="w-50 h-50 mt-5"></canvas>

            <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var chartData = <?php echo json_encode($chartData); ?>;
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.map(item => item[0] + ':00'),
                        datasets: [{
                            label: 'Response Time last 24 hours',
                            data: chartData.map(item => item[1]),
                            borderColor: 'rgb(255, 99, 132)',
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: 'hour',
                                    stepSize: 4,
                                    displayFormats: {
                                        hour: 'H:mm'
                                    }
                                },
                                ticks: {
                                    autoSkip: true,
                                    maxTicksLimit: 6
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>
            <br>
        </div>
    </div>
@endsection
