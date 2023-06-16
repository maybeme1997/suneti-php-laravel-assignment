@extends('layout')

@section('content')
    <div class="container">
        <h1>Edit Publisher</h1>

        <form method="POST" action="{{ route('publishers.update', $publisher->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $publisher->name }}" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ $publisher->location }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
