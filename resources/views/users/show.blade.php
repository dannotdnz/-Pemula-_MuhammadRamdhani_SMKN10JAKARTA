@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>User Details</h2>
        <p><strong>ID:</strong> {{ $user->id }}</p>
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><a href="/home" class="btn btn-primary">Kembali</a></p>
    </div>
@endsection
