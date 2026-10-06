<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::with('category')->get();
            return response()->json($product);
        }
        return view('admin.products.index', ['title' => 'Product Index']);
    }

    // ------------------------------ Create ------------------------------

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', get_defined_vars(), ['title' => 'Create Product']);
    }

    // ------------------------------ Create ------------------------------

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'stock' => 'required|integer',
            'sku' => 'required|string|unique:products,sku',
            'category' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product();
        $product->title = $request->title;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $product->sku = $request->sku;
        $product->category_id = $request->category;
        $product->tags = $request->tags;
        $product->description = $request->description;

        if ($request->hasFile('images')) {
            $imageData = [];
            foreach ($request->file('images') as $image) {
                $originalName = $image->getClientOriginalName();
                $imagePath = $image->storeAs('products/', $originalName, 'public');
                $imageData[] = $imagePath;
            }
            $product->images = json_encode($imageData);
        }

        $product->save();

        return response()->json([
            'message' => 'Product added successfully!',
            'product' => $product->only(['id', 'title', 'images']),
        ], 201);
    }

    // ------------------------------ Edit ------------------------------

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', get_defined_vars(), ['title' => 'Edit Product']);
    }

    // ------------------------------ Update ------------------------------

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'stock' => 'required|integer',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'category' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'description' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->title = $request->title;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $product->sku = $request->sku;
        $product->category_id = $request->category;
        $product->tags = $request->tags;
        $product->description = $request->description;

        if ($request->hasFile('images')) {
            $imageData = [];
            foreach ($request->file('images') as $image) {
                $originalName = $image->getClientOriginalName();
                $imagePath = $image->storeAs('products/', $originalName, 'public');
                $imageData[] = $imagePath;
            }
            $product->images = json_encode($imageData);
        }

        $product->save();

        return response()->json([
            'message' => 'Product updated successfully!',
            'product' => $product->only(['id', 'title', 'images']),
        ], 200);
    }

    // ------------------------------ Delete ------------------------------

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!',
        ]);
    }
}
