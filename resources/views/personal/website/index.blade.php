@extends('layouts.personal')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Uptime Checker</h1>
            <a href="{{ route('personal.website.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add website</a>
        </div>
        <!-- Content Row -->

        <div class="row">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Your Checkin Websites</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered dataTable" id="dataTable" width="100%"
                                        cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                        style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending"
                                                    style="width: 149px;">Title</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Position: activate to sort column ascending"
                                                    style="width: 230px;">Website</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Office: activate to sort column ascending"
                                                    style="width: 105px;">E-mail for notification</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Age: activate to sort column ascending"
                                                    style="width: 45px;">Check frequency</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1"
                                                    aria-label="Start date: activate to sort column ascending"
                                                    style="width: 99px;">Status</th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="3" aria-label="Salary: activate to sort column ascending"
                                                    style="width: 88px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">Title</th>
                                                <th rowspan="1" colspan="1">Website</th>
                                                <th rowspan="1" colspan="1">E-mail for notification</th>
                                                <th rowspan="1" colspan="1">Check frequency</th>
                                                <th rowspan="1" colspan="1">Status</th>
                                                <th class="text-center" rowspan="1" colspan="3">Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($websites as $website)
                                            <tr class="odd">
                                                <td class="sorting_1">{{ $website->title }}</td>
                                                <td>http(s)://{{$website->website}}</td>
                                                <td>{{$website->email}}</td>
                                                <td>{{$website->interval}}</td>
                                                <td>{{$website->status ? 'Enabled' : 'Disabled'}}</td>
                                                <td class="text-center">
                                                    
                                                    <a class="btn btn-primary btn-sm" href="{{ route('personal.website.show', $website->id) }}" role="button">Show</a>
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-success btn-sm" href="{{ route('personal.website.edit', $website->id) }}" role="button">Edit</a>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('personal.website.destroy', $website->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                            {{-- <tr class="even">
                                                <td class="sorting_1">Angelica Ramos</td>
                                                <td>Chief Executive Officer (CEO)</td>
                                                <td>London</td>
                                                <td>47</td>
                                                <td>2009/10/09</td>
                                                <td>$1,200,000</td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div>
                                {{ $websites->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
