@extends('layout')

@section('content')
    <div class="container">
        <h1>Create Writer</h1>

        <form method="POST" action="{{ route('writers.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="birth_date">Birth Date:</label>
                <input type="date" name="birth_date" id="birth_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" name="country" id="country" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
