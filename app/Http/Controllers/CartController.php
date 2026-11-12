<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $productIds = array_keys($cart);
        // Selalu ambil harga terbaru dari database untuk keamanan
        $products = Product::whereIn('id', $productIds)->get();

        $total = 0;
        $cartItems = [];

        foreach ($products as $product) {
            $qty = $cart[$product->id];
            $subtotal = $product->price * $qty;
            $total += $subtotal;

            $cartItems[] = (object)[
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => $subtotal
            ];
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $qty = $request->integer('quantity');

        if ($product->stock < $qty) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = $request->session()->get('cart', []);

        // Tambah kuantitas jika barang sudah ada di keranjang
        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id] + $qty;
            if ($product->stock < $newQty) {
                return back()->with('error', 'Total kuantitas melebihi stok yang tersedia.');
            }
            $cart[$product->id] = $newQty;
        } else {
            $cart[$product->id] = $qty;
        }

        $request->session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $qty = $request->integer('quantity');

        if ($product->stock < $qty) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = $request->session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id] = $qty;
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Kuantitas diperbarui.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
