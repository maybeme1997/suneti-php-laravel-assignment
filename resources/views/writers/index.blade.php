@extends('layout')

@section('content')
    <div class="container">
        <h1>Writers</h1>
        <a href="{{ route('writers.create') }}" class="btn btn-primary">Add Writer</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Birth Date</th>
                    <th>Country</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($writers as $writer)
                    <tr>
                        <td>{{ $writer->name }}</td>
                        <td>{{ $writer->birth_date }}</td>
                        <td>{{ $writer->country }}</td>
                        <td>
                            <a href="{{ route('writers.edit', $writer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
