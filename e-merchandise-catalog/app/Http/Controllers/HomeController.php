<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->orderBy('order')->get();
        $categories = Category::where('is_active', true)->get();
        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('home', compact('banners', 'categories', 'products'));
    }

    public function search(Request $request)
    {
        $query = $request->q;
        $banners = Banner::where('is_active', true)->orderBy('order')->get();
        $categories = Category::where('is_active', true)->get();

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($request->category, function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->with('category')
            ->paginate(12);

        return view('home', compact('banners', 'categories', 'products', 'query'));
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('product-detail', compact('product', 'related'));
    }
}
