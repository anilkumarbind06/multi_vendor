<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    // List all vendors
    public function index()
    {
        return response()->json(
            Vendor::with('products')->get()
        );
    }

    // Show single vendor
    public function show($id)
    {
        return response()->json(
            Vendor::with('products')->findOrFail($id)
        );
    }
}
