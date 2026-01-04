<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::latest()->get();

        return response()->json($category);
    }

    public function show(Category $category)
    {
        $category->load(['posts' => fn ($q) => $q->latest()]);

        return response()->json($category);
    }
}
