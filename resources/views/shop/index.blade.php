@extends('layouts.app')
@section('title', 'Katalog Produk')
@section('content')
<div class="row" style="align-items: flex-start; gap: 24px">
    <!-- Sidebar Filter -->
    <div class="card" style="width: 250px; flex-shrink: 0">
        <form method="GET" action="{{ route('shop.index') }}">
            <input type="hidden" name="sort" value="{{ request('sort') }}">

            <label>Pencarian
                <input class="input" name="q" value="{{ request('q') }}" placeholder="Cari nama...">
            </label>

            <label>Kategori
                <select class="input" name="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" @selected(request('category') == $cat->slug)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>Harga Minimum
                <input class="input" type="number" name="min_price" value="{{ request('min_price') }}">
            </label>

            <label>Harga Maksimum
                <input class="input" type="number" name="max_price" value="{{ request('max_price') }}">
            </label>

            <label style="display:flex; align-items:center; gap:8px; margin-top:10px">
                <input type="checkbox" name="in_stock" value="1" @checked(request('in_stock'))> Hanya stok tersedia
            </label>

            <button class="btn" style="width: 100%; margin-top: 15px">Terapkan Filter</button>
            <a href="{{ route('shop.index') }}" class="btn btn-light" style="display:block; text-align:center; margin-top:10px">Reset</a>
        </form>
    </div>

    <!-- Product Grid -->
    <div style="flex-grow: 1">
        <div class="row" style="justify-content: space-between; margin-bottom: 16px">
            <h2 style="margin:0">Katalog Produk</h2>
            <form method="GET" action="{{ route('shop.index') }}">
                @foreach(request()->except(['sort', 'page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <select class="input" name="sort" onchange="this.form.submit()" style="width: auto; margin:0">
                    <option value="">Terbaru</option>
                    <option value="price_asc" @selected(request('sort') == 'price_asc')>Harga: Termurah</option>
                    <option value="price_desc" @selected(request('sort') == 'price_desc')>Harga: Termahal</option>
                    <option value="name_asc" @selected(request('sort') == 'name_asc')>Nama: A-Z</option>
                    <option value="name_desc" @selected(request('sort') == 'name_desc')>Nama: Z-A</option>
                </select>
            </form>
        </div>

        <div class="grid">
            @forelse($products as $product)
                <div class="card" style="margin:0; padding:12px; display:flex; flex-direction:column">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="thumb" style="width:100%; height:180px; object-fit:cover; margin-bottom:10px">
                    @else
                        <div class="thumb" style="width:100%; height:180px; display:flex; align-items:center; justify-content:center; background:#eee; margin-bottom:10px">No Image</div>
                    @endif
                    <div class="muted" style="font-size:0.85rem">{{ $product->category->name }}</div>
                    <h3 style="margin:8px 0; font-size:1.1rem">
                        <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    <div class="price" style="margin-bottom:10px">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    <div style="margin-top:auto">
                        <span style="font-size:0.9rem; font-weight:bold; color: {{ $product->stock > 0 ? 'green' : 'red' }}">
                            Stok: {{ $product->stock > 0 ? $product->stock : 'Habis' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="card" style="width:100%; text-align:center">Tidak ada produk ditemukan.</div>
            @endforelse
        </div>
        <div style="margin-top: 20px">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
