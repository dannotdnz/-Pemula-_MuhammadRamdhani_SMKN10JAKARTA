<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Wallet;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'bank'
        ]);
        Role::create([
            'name' => 'kantin'
        ]);
        Role::create([
            'name' => 'siswa'
        ]);

        User::create([
            'name' => 'Admin Sekolah',
            'username' => 'admin',
            'password' => Hash::make('admin'), 
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'Bank Sekolah',
            'username' => 'bank',
            'password' => Hash::make('bank'), 
            'role_id' => 2
        ]);
        User::create([
            'name' => 'Kantin Sekolah',
            'username' => 'kantin',
            'password' => Hash::make('kantin'),
            'role_id' => 3
        ]);
        User::create([
            'name' => 'Ramdhani',
            'username' => 'siswa',
            'password' => Hash::make('siswa'),
            'role_id' => 4
        ]);
        
        Category::create([
            'name' => 'Makanan'
        ]);
        Category::create([
            'name' => 'Minuman'
        ]);
        Category::create([
            'name' => 'Snack'
        ]);

        Product::create([
            'name' => 'Nasi Lemak',
            'price' => 10000,
            'stock' => 50,
            'photo' => NULL,
            'description' => 'Nasi Lemak Uncle Muthu',
            'stand' => 1,
            'category_id' => 1,
        ]);
        Product::create([
            'name' => 'Ice ABCD',
            'price' => 5000,
            'stock' => 50,
            'photo' => NULL,
            'description' => 'Ice ABCD Uncle Muthu',
            'stand' => 2,
            'category_id' => 2,
        ]);Product::create([
            'name' => 'Gorengan',
            'price' => 3000,
            'stock' => 50,
            'photo' => NULL,
            'description' => 'Gorengan Sedappp',
            'stand' => 3,
            'category_id' => 3,
        ]);

        Wallet::create([
            'user_id' => 4,
            'credit' => 100000,
            'debit' => null,
            'description' => 'pembukaan tabungan'
        ]);
        Wallet::create([
            'user_id' => 4,
            'credit' => 10000,
            'debit' => null,
            'description' => 'pembelian produk'
        ]);
        Wallet::create([
            'user_id' => 4,
            'credit' => 13000,
            'debit' => null,
            'description' => 'pembelian produk'
        ]);

        Transaction::create([
            'user_id' => 4,
            'product_id' => 1,
            'status' => 'dikeranjang',
            'order_code' => 'INV_12345',
            'price' => 5000,
            'quantity' => 1
        ]);
        Transaction::create([
            'user_id' => 4,
            'product_id' => 2,
            'status' => 'dikeranjang',
            'order_code' => 'INV_12345',
            'price' => 5000,
            'quantity' => 1
        ]);
        Transaction::create([
            'user_id' => 4,
            'product_id' => 3,
            'status' => 'dikeranjang',
            'order_code' => 'INV_12345',
            'price' => 5000,
            'quantity' => 1
        ]);

        $total_debit = 0;
        
        $transactions = Transaction::where('order_code'=='INV_12345');
        foreach($transactions as $transaction)
        {
            $total_price = $transaction->price * $transaction->quantity;

            $total_debit += $total_price;
        }
        Wallet::create([
            'user_id' => 4,
            'debit' => $total_debit,
            'description' => 'pembelian produk'
        ]);
        foreach($transactions as $transaction)
        {
            Transaction::find($transaction->id)->update([
                'status' => 'dibayar'
            ]);
        }
        foreach($transactions as $transaction)
        {
            Transaction::find($transaction->id)->update([
                'status' => 'diambil'
            ]);
        }
    }
}
