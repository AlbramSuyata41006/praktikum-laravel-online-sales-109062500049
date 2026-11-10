@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="card row" style="align-items: flex-start; gap:30px">
    <div style="flex:1">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" style="width:100%; border-radius:10px">
        @else
            <div style="width:100%; height:300px; background:#eee; display:flex; align-items:center; justify-content:center; border-radius:10px">No Image</div>
        @endif
    </div>
    <div style="flex:1">
        <div class="muted">{{ $product->category->name }}</div>
        <h1 style="margin: 10px 0">{{ $product->name }}</h1>
        <p class="muted">SKU: {{ $product->sku }}</p>
        <h2 class="price" style="font-size:2rem; margin:16px 0">Rp{{ number_format($product->price, 0, ',', '.') }}</h2>
        <div style="margin-bottom: 20px">
            <strong>Stok Tersedia:</strong>
            <span style="color: {{ $product->stock > 0 ? 'green' : 'red' }}; font-weight:bold">{{ $product->stock }} unit</span>
        </div>

        <p style="line-height: 1.6">{{ $product->description }}</p>

        @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.store', $product) }}" style="margin-top:20px">
                @csrf
                <div class="row">
                    <input class="input" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width:80px">
                    <button class="btn">Tambah ke Keranjang</button>
                </div>
            </form>
        @else
            <button class="btn btn-danger" disabled style="margin-top:20px">Stok Habis</button>
        @endif
    </div>
</div>
@endsection
