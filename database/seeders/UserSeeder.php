<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash ; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $password = Hash::make('password123');

        User::create([
            'name'=>'Admin',
            'email'=>'admin@stockflow.ci',
            'password'=>$password,
            'role'=>'admin',
        ]);

        User::create([
            'name'=>'Manager',
            'email'=>'manager@stockflow.ci',
            'password'=>$password,
            'role'=>'manager',
        ]);

        User::create([
            'name'=>'Seller',
            'email'=>'seller@stockflow.ci',
            'password'=>$password,
            'role'=>'seller',
        ]);
    }
}
