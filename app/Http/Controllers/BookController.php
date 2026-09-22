<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //

    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort');
        $order = $request->query('order');

        $allowedSort = ['id', 'title', 'author', 'price', 'stock'];

        if (!in_array($sort, $allowedSort)) {
            $sort = 'id';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }
        $query = Book::orderBy($sort, $order);

        if ($search) {
            $query = $query->where("title", "like", "%" . $search . "%");
        }

        $book = $query->paginate(10);

        return BookResource::collection($book)->additional(
            [
                'message' => 'book retrieved successfully',
            ]
        )->response()->setStatusCode(200);
    }

    public function search($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Null, no any matches',
            ], 404);
        }
        return new BookResource($book)->additional(
            [
                'message' => 'book searched successfully',
            ]
        )->response()->setStatusCode(200);
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

        return new BookResource($book)->additional(
            [
                'message' => 'Book added successfully',
            ]
        )->response()->setStatusCode(201);
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

        return new BookResource($book)->additional(
            [
                'message' => 'book updated successfully',
            ]
        )->response()->setStatusCode(200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'book not found',
                'id' => $id
            ], 404);
        }

        $book->delete();

        return new BookResource($book)->additional(
            [
                'message' => 'Book deleted successfully',
            ]
        )->response()->setStatusCode(200);
    }

    public function expensiveBooks(Request $request){
        $sort = $request->query('sort');
        $order = $request->query('order');
        $allowedSort = ['price', 'name','stock','author', 'id'];

        if (!in_array($sort, $allowedSort)) {
            $sort = 'price';
        }
        if(!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query = Book::orderBy($sort, $order);
        $query = $query->where('price', '>', '10000');
        $book = $query->paginate(10);
        
        return BookResource::collection($book)->additional(
            [
                'message'=> 'Expensive book retrieved successfully',
            ]
        )->response()->setStatusCode(200);
    }
}
