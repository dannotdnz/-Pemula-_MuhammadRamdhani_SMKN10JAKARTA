@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Produk</h2>
        <table class="table">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Stok</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->stock}}</td>
                </tr>
            </tbody>
        </table>
        <a href="/home" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
