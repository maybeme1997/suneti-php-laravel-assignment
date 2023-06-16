@extends('layout')

@section('content')
    <div class="container">
        <h1>Books</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Publication Year</th>
                    <th>Price</th>
                    <th>Genre</th>
                    <th>Subgenre</th>
                    <th>Writer</th>
                    <th>Publisher</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->ISBN }}</td>
                        <td>{{ $book->publication_year }}</td>
                        <td>{{ $book->price }}</td>
                        <td>{{ $book->genre }}</td>
                        <td>{{ $book->subgenre }}</td>
                        <td>{{ $book->writer->name }}</td>
                        <td>{{ $book->publisher->name }}</td>
                        <td>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
