<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    </body>
    @forelse ($wallets as $wallet)
    <div class="card card-body bg-base-100 border border-white">
        @if ($wallet->credit != 0)
        <span class="text-lg font-bold text-green-500">Topup: +Rp.{{number_format($wallet->credit)}}</span>
        <div class="flex">
            <span class="badge badge-outline">{{ $wallet->user->name ?? Auth::user()->name }}</span>
            <span class="badge badge-outline">Status: {{$wallet->status}}</span>
        </div>
        <span class="text-xs text-gray-500">{{$wallet->updated_at}}</span>
        @endif
    
    </div>
    @empty
        <span>no data</span>
    @endforelse
</html>