@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Produk Baru</h2>
            <form action="{{route('product.update',$product->id)}}" method="post">
            @csrf
            @method('put')
            <label for="name">Name</label>
            <input type="text" name="name" value="{{$product->name}}" class="form-control">
            <label for="price">Harga</label>
            <input type="number" name="price" value="{{$product->price}}" class="form-control">
            <label for="stock">Stock</label>
            <input type="number" name="stock" value="{{$product->stock}}" class="form-control">
            <label for="description">Deskripsi</label>
            <input type="text" name="description" value="{{$product->description}}" class="form-control">
            <label for="stand">Stand</label>
            <input type="number" name="stand" value="{{$product->stand}}" class="form-control">
            <label for="category_id">Category</label>
            <input type="number" name="category_id" value="{{$product->category_id}}" class="form-control">
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
@endsection