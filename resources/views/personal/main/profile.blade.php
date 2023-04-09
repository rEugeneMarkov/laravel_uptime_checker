@extends('layouts.personal')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ auth()->user()->name }} profile</h1>
        </div>
        <div class="row">
            <div>
            <table class="table table-bordered border-warning">
                <tbody>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    
                </tbody>
            </table>
            </div>
        </div>

    </div>
@endsection
