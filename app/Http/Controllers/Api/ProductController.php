<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        return response()->json(
            Product::with('vendor')->get()
        );
    }

    // Show single product
    public function show($id)
    {
        return response()->json(
            Product::with('vendor')->findOrFail($id)
        );
    }
}
