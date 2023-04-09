@extends('layouts.personal')

@section('content')
    <div class="container">
        <div class="col-6">
            <table class="table table-bordered border-{{$website->status ==='Disabled' ? 'danger' : 'success'}}">
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td>{{ $website->id }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Title</th>
                        <td>{{ $website->title }}</td>
                    </tr>
                    <tr>
                        <th scope="row">URL</th>
                        <td>{{ $website->website }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Check frequency</th>
                        <td>{{ $website->frequency->title }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td class="bg-{{$website->status ==='Disabled' ? 'danger' : 'success'}}">{{ $website->status }}</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tr>
                    @if ($website->status ==='Disabled')
                    <td>
                        <a class="btn btn-warning" href="{{ route('personal.website.activate', $website->id) }}" role="button">Activate</a>
                    </td>
                    @endif
                    
                    <td>
                        <a class="btn btn-success" href="{{ route('personal.website.edit', $website->id) }}" role="button">Edit</a>
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
    </div>
@endsection
