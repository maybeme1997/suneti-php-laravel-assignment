@extends('layout')

@section('content')
    <div class="container">
        <h1>Publishers</h1>
        <a href="{{ route('publishers.create') }}" class="btn btn-primary">Add Publisher</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($publishers as $publisher)
                    <tr>
                        <td>{{ $publisher->name }}</td>
                        <td>{{ $publisher->location }}</td>
                        <td>
                            <a href="{{ route('publishers.edit', $publisher->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
