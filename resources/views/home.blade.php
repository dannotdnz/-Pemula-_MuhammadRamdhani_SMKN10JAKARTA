@extends('layouts.app')

@section('content')
<div class="container">

@if (Auth::user()->role_id == 1)
<div class="container">
        <h2>Daftar Pengguna</h2>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{$user->username}}</td>
                        <td>
                            <a href="{{ route('user.show', $user->id) }}" class="btn btn-info">Show</a>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('user.destroy', $user->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{route('user.create')}}" class="btn btn-success">Create User</a>

        <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Tampilan Transactions History -->
                        <div class="card mb-3">
                            <div class="card-header text-bg-warning fw-bold text-center">Transactions History</div>
                            <div class="card-body">
                                @foreach($transactions as $key => $transaction)
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    {{ $transaction[0]->order_code}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-secondary" style="font-size: 12px;">
                                                    {{$transaction[0]->created_at}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end align-items-center">
                                            <a href="{{route('download', ['order_code' => $transaction[0]->order_code])}}" class="btn btn-success" target="blank">Download</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    @endif

@if(Auth::user()->role_id == 2)
        <div class="col md-12">
            <div class="row">
                <div class="col">
                    <div class="row text-secondary">Welcome,</div>
                    <div class="row fw-bold" style="font-size: 25px;">
                        {{Auth::user()->name}}
                    </div>
                </div>
            </div>
            <div class="col text-end">
                                <a href="{{route('topup')}}" class="btn btn-success">History TopUp</a>
                                <a href="{{route('withdraw')}}" class="btn btn-success">History Withdraw</a>
                                <button type="button" class="btn btn-primary px-5" data-bs-target="#formTransfer" data-bs-toggle="modal">Withdraw</button>
                                <button type="button" class="btn btn-primary px-5" data-bs-target="#formTopUp" data-bs-toggle="modal">Top Up</button>

                                <!-- Modal -->
                                <form action="/topup-from-bank" method="post">
                                    @csrf
                                    <div class="modal fade" id="formTopUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <select name="user_id">
                                                            @foreach($users as $user)
                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" name="credit" id="" class="form-control" min="10000" value="10000">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Top Up Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Modal Tarik Tunai -->
                                <form action="/withdraw-from-bank" method="post">
                                    @csrf
                                    <div class="modal fade" id="formTransfer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Withdraw</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <select name="user_id">
                                                            @foreach($users as $user)
                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" name="debit" id="" class="form-control" min="10000" value="10000">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Withdraw Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End Modal Tarik Tunai -->
                            </div>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header dw-bold">
                            Saldo
                        </div>
                        <div class="card-body">
                            Rp. {{number_format($saldo)}}
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header dw-bold">
                            Jumlah Nasabah
                        </div>
                        <div class="card-body">
                            {{$nasabah}}
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Tampilan Transactions History -->
                        <div class="card mb-3">
                            <div class="card-header text-bg-warning fw-bold text-center">Transactions History</div>
                            <div class="card-body">
                                @foreach($transactions as $key => $transaction)
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    {{ $transaction[0]->order_code}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-secondary" style="font-size: 12px;">
                                                    {{$transaction[0]->created_at}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end align-items-center">
                                            <a href="{{route('download', ['order_code' => $transaction[0]->order_code])}}" class="btn btn-success" target="blank">Download</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
    </div>
            </div>
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{session('status')}}
                </div>
            @endif
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Nasabah</th>
                            <th>Permintaan Saldo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($request_topup as $key => $request)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$request->user->username}}</td>
                                <td>@if ($request->credit)
                                                            <span class="text-warning">Top Up:</span> {{ number_format($request->credit) }}
                                                        @elseif ($request->debit)
                                                            <span class="text-danger">Withdraw:</span> {{ number_format($request->debit) }}
                                                        @endif</td>
                                <form action="/request_topup/{{$request->id}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="$request->id">
                                    <td><button type="submit" class="btn btn-primary">SETUJU</button></td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@if(Auth::user()->role_id == 3)
<div class="row">
            <h2>Daftar Produk</h2>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Stock</th>
                        <th>Stand</th>
                        <th>Category</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->stand }}</td>
                            <td>{{ $product->category_id }}</td>
                            <td>
                                <a href="{{route('product.show',$product->id)}}" class="btn btn-info">Lihat</a>
                                <a href="{{route('product.edit',$product->id)}}" class="btn btn-warning">Edit</a>
                                <form action="{{route('product.destroy',$product->id)}}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{route('product.create')}}" class="btn btn-success">Create Product</a>
                        <div class="card mb-3">
                            <div class="card-header text-bg-warning fw-bold text-center">Transactions History</div>
                            <div class="card-body">
                                @foreach($transactions as $key => $transaction)
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    {{ $transaction[0]->order_code}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-secondary" style="font-size: 12px;">
                                                    {{$transaction[0]->created_at}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end align-items-center">
                                            <a href="{{route('download', ['order_code' => $transaction[0]->order_code])}}" class="btn btn-success" target="blank">Download</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
@endif

@if(Auth::user()->role_id == 4)
<div class="col-md-12">
            <!-- User Information Section -->
            <div class="container mb-3">
                <div class="text-center">
                    <div class="row">
                        <div class="col">
                            <div class="row text-secondary">Selamat Datang,</div>
                            <div class="row fw-bold" style="font-size: 25px;">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                    </div>
                    <div class="row text-black p-3" style="height: 170px;">
                        <div class="col">
                            <div class="row">
                                <div class="col">Saldo Anda:</div>
                            </div>
                            <div class="row" style="font-size: 50px;">
                                <div class="col">Rp. {{ number_format($saldo) }}</div>
                            </div>
                            <div class="col text-center">
                                    <button type="button" class="btn btn-success px-5" data-bs-target="#formTransfer" data-bs-toggle="modal">Withdraw</button>
                                    <button type="button" class="btn btn-success px-5" data-bs-target="#formTopUp" data-bs-toggle="modal">Top Up</button>

                                    <!-- Modal -->
                                    <form action="{{ route('TopUpNow') }}" method="post">
                                        @csrf
                                        <div class="modal fade" id="formTopUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="number" name="credit" id="" class="form-control" min="10000" value="10000">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Top Up Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Modal Tarik Tunai -->
                                    <form action="{{ route('withdrawNow') }}" method="post">
                                        @csrf
                                        <div class="modal fade" id="formTransfer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Withdraw</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="number" name="debit" id="" class="form-control" min="10000" value="10000">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Withdraw Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Modal Tarik Tunai -->
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <!-- Product Cards Section -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header text-bg-warning text-white fw-bold text-center">Produk</div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($products as $product)
                                <div class="col">
                                    <form action="{{ route('addToCart') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                        <input type="hidden" value="{{ $product->price }}" name="price">
                                        <div class="card">
                                            <div class="card-header">
                                                {{ $product->name }}
                                            </div>
                                            <div class="card-body">
                                                <div>{{ $product->description }}</div>
                                                <div>{{ $product->stock }}</div>
                                                <div>Harga: Rp. {{ number_format($product->price) }}</div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3">
                                                            <label for="quantity" class="form-label">Jumlah</label>
                                                            <input type="number" name="quantity" id="quantity" class="form-control" value="0" min='0'>
                                                        </div>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="d-grid gap-2">
                                                            <button type="submit" class="btn btn-secondary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                                                    <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                                </svg> <span style="font-size: 12px;">Tambah</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Tampilan Baskets -->
                        <div class="card mb-3">
                            <div class="card-header text-bg-warning fw-bold text-center">
                                Baskets
                            </div>
                            <div class="card-body">
                                <ul>
                                    @foreach($carts as $cart)
                                        <li>{{ $cart->product->name }} | {{ $cart->quantity}} x Rp. {{ number_format($cart->price) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-footer">
                                <form action="{{ route('payNow')}}" method="POST">
                                    <div class="d-grip gap-2 d-flex justify-content-end">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Bayar Sekarang</button>
                                    </div>
                                </form>
                                <div class="d-flex justify-content-end">
                                    Total Biaya: {{ $total_biaya }}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- Tampilan Mutasi Wallet -->
                    <div class="card mb-3">
                        <div class="card-header text-bg-warning fw-bold text-center">
                            Mutasi Wallet
                        </div>
                        @foreach($mutasi as $data)
                            <div class="card-body container">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="row fw-bold">{{$data->description}} </div>
                                        <div class="row text-secondary" style="font-size: 10px;">{{$data->created_at}}</div>
                                    </div>
                                    <div class="col-4">{{ $data->credit ? '+ Rp '.number_format($data->credit):'' }} {{ $data->debit ? '- Rp. '.number_format($data->debit):''}}
                                        <span class="badge text-bg-warning">{{$data->status == 'proses' ? 'PROSES' : ''}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Tampilan Transactions History -->
                        <div class="card mb-3">
                            <div class="card-header text-bg-warning fw-bold text-center">Transactions History</div>
                            <div class="card-body">
                                @foreach($transactions as $key => $transaction)
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col fw-bold">
                                                    {{ $transaction[0]->order_code}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-secondary" style="font-size: 12px;">
                                                    {{$transaction[0]->created_at}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-end align-items-center">
                                            <a href="{{route('download', ['order_code' => $transaction[0]->order_code])}}" class="btn btn-success" target="blank">Download</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>                                            
            </div>
        </div>
@endif
</div>
@endsection
