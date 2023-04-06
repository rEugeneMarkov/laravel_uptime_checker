@extends('layouts.welcome')

@section('content')
    <div class="container">
        <div>
            <a class="btn btn-primary" href="{{ route('personal.website.create') }}" role="button">+ Add website</a>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Website</th>
                    <th scope="col">E-mail for notification</th>
                    <th scope="col">Check frequency</th>
                    <th scope="col" colspan="2" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($websites as $website)
                    <tr>
                        <th scope="row">{{ $website->id }}</th>
                        <td>{{ $website->title }}</td>
                        <td>https://{{ $website->website }}</td>
                        <td>{{ $website->email }}</td>
                        <td>{{ $website->frequency->title }}</td>
                        <td class="text-center">
                            <a class="btn btn-success" href="{{ route('personal.website.edit', $website->id) }}" role="button">Edit</a>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('personal.website.destroy', $website->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $websites->links() }}
        </div>
    </div>
@endsection
