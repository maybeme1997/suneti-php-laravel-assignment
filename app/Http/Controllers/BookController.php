<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all()->sortByDesc('sort_order');
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        $writers = Writer::all();
        $publishers = Publisher::all();

        return view('books.create', compact('writers', 'publishers'));
    }

    /**
     * Store a newly created book in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:255',
            'stock_amount' => 'required|integer|min:0',
            'subgenre' => 'required|string|max:255',
            'writer_id' => 'required|exists:writers,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        Book::create([
            'title' => $request->input('title'),
            'ISBN' => $request->input('ISBN'),
            'publication_year' => $request->input('publication_year'),
            'price' => $request->input('price'),
            'genre' => $request->input('genre'),
            'sort_order' => $request->input('stock_amount') > 0 ? 1 : -1,
            'stock_amount' => $request->input('stock_amount'),
            'subgenre' => $request->input('subgenre'),
            'writer_id' => $request->input('writer_id'),
            'publisher_id' => $request->input('publisher_id'),
        ]);

        return redirect()->route('books.index');
    }

    /**
     * Show the form for editing the specified book.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\View\View
     */
    public function edit(Book $book): \Illuminate\View\View
    {
        $writers = Writer::all();
        $publishers = Publisher::all();

        return view('books.edit', compact('book', 'writers', 'publishers'));
    }

    /**
     * Update the specified book in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Book $book): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'genre' => 'required|string|max:255',
            'subgenre' => 'required|string|max:255',
            'stock_amount' => 'required|integer|min:0',
            'writer_id' => 'required|exists:writers,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        $newSortOrder = -1;
        $currentSortOrder = $book->sort_order;

        if ($request->input('stock_amount') > 0) {
            $newSortOrder = max($currentSortOrder, 1);
        }

        $book->update([
            'title' => $request->input('title'),
            'ISBN' => $request->input('ISBN'),
            'publication_year' => $request->input('publication_year'),
            'price' => $request->input('price'),
            'genre' => $request->input('genre'),
            'subgenre' => $request->input('subgenre'),
            'sort_order' => $newSortOrder,
            'stock_amount' => $request->input('stock_amount'),
            'writer_id' => $request->input('writer_id'),
            'publisher_id' => $request->input('publisher_id'),
        ]);

        if ($currentSortOrder > 0 && $newSortOrder < 0) {
            $this->closeSortOrderGaps($currentSortOrder);
        }

        return redirect()->route('books.index');
    }

    /**
     * Reorder the books.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reOrder(Request $request, Book $book): \Illuminate\Http\RedirectResponse
    {
        $up = $request->input('up');
        $down = $request->input('down');

        // If both up and down are set, null or the stock is 0, redirect back
        if (!($up === null xor $down === null) || $book->stock_amount === 0) {
            return redirect()->route('books.index');
        }

        $currentSortOrder = $book->sort_order;
        $newSortOrder = $currentSortOrder;

        if ($up !== null) {
            $newSortOrder += $up;
            $maxSortOrder = Book::max('sort_order');

            // If the new sort order is too high, set it to the highest sort order + 1
            if ($newSortOrder > $maxSortOrder) {
                $newSortOrder = $maxSortOrder + 1;
            }

        } else {
            $newSortOrder -= $down;

            // If the new sort order is too low, set it to the lowest sort order 1
            if ($newSortOrder < 1) {
                $newSortOrder = 1;
            }
        }

        $book->update([
            'sort_order' => $newSortOrder,
        ]);

        $this->closeSortOrderGaps($currentSortOrder);

        return redirect()->route('books.index');
    }

    /**
     * Close sort order gaps if they exist on given sort order.
     *
     * @param int $sortOrder
     */
    private function closeSortOrderGaps(int $sortOrder): void
    {
        // If the operation leaves a gap, decrement all sort-orders above it
        if (Book::where('sort_order', $sortOrder)->count() == 0) {
            Book::where('sort_order', '>', $sortOrder)->decrement('sort_order');
        }
    }
}
