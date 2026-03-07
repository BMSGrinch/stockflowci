<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // On Appelle les seeders ici 
        $this->call([
            UserSeeder::class , 
            SupplierSeeder::class , 
            ProductSeeder::class ,
            SaleSeeder::class,
        ]);
        
    }
}
