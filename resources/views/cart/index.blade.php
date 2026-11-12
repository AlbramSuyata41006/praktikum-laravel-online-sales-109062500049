@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('content')
<div class="row" style="justify-content: space-between; align-items:center; margin-bottom: 20px">
    <h1 style="margin:0">Keranjang Belanja</h1>
</div>

@if(count($cartItems) > 0)
    <div class="card">
        <table>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Kuantitas</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
            @foreach($cartItems as $item)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px">
                            @if($item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" style="width:50px; height:50px; object-fit:cover; border-radius:5px">
                            @else
                                <div style="width:50px; height:50px; background:#eee; border-radius:5px"></div>
                            @endif
                            <a href="{{ route('shop.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                        </div>
                    </td>
                    <td>Rp{{ number_format($item->product->price, 0, ',', '.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.update', $item->product) }}" style="display:flex; gap:5px; margin:0">
                            @csrf
                            @method('PUT')
                            <input type="number" class="input" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" style="width:70px; margin:0">
                            <button class="btn btn-light" style="padding: 5px 10px">Update</button>
                        </form>
                    </td>
                    <td><strong>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                    <td>
                        <form method="POST" action="{{ route('cart.destroy', $item->product) }}" style="margin:0">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" style="padding: 5px 10px">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align:right; font-size:1.2rem"><strong>Total:</strong></td>
                <td colspan="2" style="font-size:1.2rem; color:#111"><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="text-align:right; margin-top:20px">
        <a href="{{ route('shop.index') }}" class="btn btn-light">Lanjut Belanja</a>
        <a href="#" class="btn" style="margin-left:10px">Lanjut Checkout (M6)</a>
    </div>
@else
    <div class="card" style="text-align:center; padding:50px 20px">
        <h3 style="color:#666; margin-bottom:20px">Keranjang belanjamu masih kosong.</h3>
        <a href="{{ route('shop.index') }}" class="btn">Mulai Belanja</a>
    </div>
@endif
@endsection
