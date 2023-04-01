<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('properties');

        if ($request->has('properties')) {
            foreach ($request->get('properties') as $property => $values) {
                $query->whereHas('properties', function ($q) use ($property, $values) {
                    $q->whereIn('name', [$property])
                        ->whereIn('value', $values);
                });
            }
        }
    
        $products = $query->paginate(5);
    
        return response()->json($products);
    }
}
