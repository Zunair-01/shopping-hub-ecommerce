<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::all();
            return response()->json($categories);
        }
        return view('admin.category.index', ['title' => 'Category Index']);
    }

    // ------------------------------ Create ------------------------------

    public function create()
    {
        return view('admin.category.create', ['title' => 'Category Create']);
    }

    // ------------------------------ Store ------------------------------

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_type' => 'required|string|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'category_type' => $request->category_type,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Category saved successfully!',
        ]);
    }

    // ------------------------------ Edit ------------------------------

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', get_defined_vars(), ['title' => 'Category Updated']);
    }

    // ------------------------------ Update ------------------------------

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_type' => 'required|string|max:255',
        ]);

        $category->update([
            'category_name' => $request->input('category_name'),
            'category_type' => $request->input('category_type'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!',
        ]);
    }

    // ------------------------------ Distroy ------------------------------

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!',
        ]);
    }
}
