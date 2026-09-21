<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //

    public function index(Request $request)
    {
        $book = Book::all();
        return response()->json([
            'message' => 'Book index',
            'book' => $book
        ]);
    }

    public function search($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Book found',
            'data' => $book,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0'
        ]);

        $title = $request->input('title');
        $author = $request->input('author');
        $price = $request->input('price');
        $stock = $request->input('stock');
        $book = new Book();

        $book->title = $title;
        $book->author = $author;
        $book->price = $price;
        $book->stock = $stock;

        $book->save();

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0'
        ]);

        $title = $request->input('title');
        $author = $request->input('author');
        $price = $request->input('price');
        $stock = $request->input('stock');

        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'null no any matches',
                'data' => $book
            ], 404);
        }
        $book->title = $title;
        $book->author = $author;
        $book->price = $price;
        $book->stock = $stock;

        $book->save();

        return response()->json([
            'message' => 'Books updated successfully',
            'data' => $book
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message'=> 'book not found',
                'id' => $id
                ],404);
        }
                
        $book->delete();

        return response()->json([
            'message' => 'book deleted successfully',
            'data' => $book
        ]);
    }
}
