<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'message' => 'Product index ok',
            'products' => $products
        ]);
    }
    public function search(Request $request)
    {
        $search = $request->query('search');
        $limit = $request->query('limit');

        return response()->json([
            'message' => 'Product search ok',
            'search' => $search,
            'limit' => $limit,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer|min:1000',
        ]);


        $name = $request->input('name');
        $price = $request->input('price');

        $product = new Product();

        $product->name = $name;
        $product->price = $price;

        $product->save();

        return response()->json([
            'message' => 'Product created successfully',
            'name' => $name,
            'price' => $price,
        ]);
    }

    public function show(Request $request, $id)
    {
        $detail = $request->boolean('detail');
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'id' => $id
            ], 404);
        }   

        return response()->json([
            'message' => 'Product details',
            'id' => $id,
            'detail' => $detail,
            'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {   
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer|min:1000',
        ]);

        $name = $request->input('name');
        $price = $request->input('price');
    
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'message' => 'Product not found',
                'id' => $id
            ], 404);
        }
        $product->name = $name;
        $product->price = $price;
        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'id' => $id,
            'name' => $name,
            'price' => $price,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'message' => 'Product not found',
                'id' => $id
            ], 404);
        }
        
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'id' => $id
        ]);
    }
}
