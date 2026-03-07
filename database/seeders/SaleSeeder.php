<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Comme les ventes sont beaucoup et que j'ai la flemme je les mets dans une boucle. Aussi j'ai vu que je devais faire un service séparé pour que mon sale controller et mon sale seeder l'utilise au lieu de refaire la logique du total à chaque fois mais bon c'est r 
        
       for($vente =0 ; $vente <8 ; $vente++){
        $methods =['cash','mobile_money','carte'];
        $sale =Sale::create([
            'user_id'=> User::inRandomOrder()->first()->id,
            'total_amount'=> 0 ,
            'payment_method'=>$methods[array_rand($methods)]
           ]);
          $total = 0 ;
          $produits = Product::inRandomOrder()->take(rand(1,4))->get();
    
          foreach($produits as $produit){
                $quantity = rand(1,5);
                $sale->saleItems()->create([
                    'product_id'=>$produit->id,
                    'unit_price'=>$produit->selling_price,
                    'quantity'=>$quantity    
                ]);
                $total += $produit->selling_price * $quantity ;

                $produit->stockMovements()->create([
                    'user_id'=>$sale->user_id,
                    'movement_type'=>'sale',
                    'quantity'=>-$quantity,
                    'note'=>'Vente#' . $sale->id
                ]);
          }
          $sale->update(['total_amount'=>$total]);
        }
       }
}
