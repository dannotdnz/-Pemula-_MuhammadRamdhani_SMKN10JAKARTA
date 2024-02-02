@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Produk Baru</h2>
        <form action="{{route('product.store')}}" method="post">
            @csrf
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control">
            <label for="price">Harga</label>
            <input type="number" name="price" class="form-control">
            <label for="stock">Stock</label>
            <input type="number" name="stock"  class="form-control">
            <label for="description">Deskripsi</label>  
            <input type="text" name="description" class="form-control">
            <label for="stand">Stand</label>  
            <input type="number" name="stand" class="form-control">
            <label for="category_id">Category</label>  
            <input type="text" name="category_id" class="form-control">
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection