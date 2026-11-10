<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCatalogController extends Controller
{
    public function index(Request $request): View
    {
        // Hanya tampilkan produk yang aktif (menggunakan scopeActive dari M2)
        $query = Product::with('category')->active();

        // 1. Pencarian Keyword
        if ($request->filled('q')) {
            $keyword = $request->string('q')->toString();
            $query->where('name', 'like', "%{$keyword}%");
        }

        // 2. Filter Kategori
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        // 3. Filter Rentang Harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->integer('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->integer('max_price'));
        }

        // 4. Filter Stok Tersedia
        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // 5. Pengurutan (Sorting) dengan match
        $sort = $request->string('sort')->toString();
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            default => $query->latest(), // default: terbaru
        };

        return view('shop.index', [
            // Pagination 12 data per halaman dan bawa query parameternya
            'products' => $query->paginate(12)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function show(Product $product): View
    {
        // Tolak akses jika produk dinonaktifkan admin
        if (!$product->is_active) {
            abort(404);
        }

        return view('shop.show', compact('product'));
    }
}
