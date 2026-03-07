<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produits = [
            ['name'=>'Riz parfumé','category'=>'Alimentation'],
            ['name' => 'Huile de palme', 'category' => 'Alimentation'],
            ['name' => 'Lait concentré', 'category' => 'Alimentation'],
            ['name' => 'Savon de Marseille', 'category' => 'Hygiène'],
            ['name' => 'Gel douche', 'category' => 'Hygiène'],
            ['name' => 'Eau minérale', 'category' => 'Boissons'],
            ['name' => 'Jus de fruits', 'category' => 'Boissons'],
            ['name' => 'Café robusta', 'category' => 'Épicerie'],
            ['name' => 'Sucre blanc', 'category' => 'Épicerie'],
            ['name' => 'Lessive en poudre', 'category' => 'Entretien'],

            ['name' => 'Pâtes alimentaires', 'category' => 'Alimentation'],
            ['name' => 'Farine de blé', 'category' => 'Alimentation'],
            ['name' => 'Confiture de fraise', 'category' => 'Alimentation'],
            ['name' => 'Shampoing antipelliculaire', 'category' => 'Hygiène'],
            ['name' => 'Dentifrice menthe', 'category' => 'Hygiène'],
            ['name' => 'Savon liquide pour les mains', 'category' => 'Hygiène'],
            ['name' => 'Soda cola', 'category' => 'Boissons'],
            ['name' => 'Thé vert en sachets', 'category' => 'Boissons'],
            ['name' => 'Biscuits sablés', 'category' => 'Épicerie'],
            ['name' => 'Céréales petit-déjeuner', 'category' => 'Épicerie'],
        
            ['name' => 'Liquide vaisselle', 'category' => 'Entretien'],
            ['name' => 'Nettoyant multi-surfaces', 'category' => 'Entretien'],
            ['name' => "Désodorisant d'intérieur", 'category' => 'Entretien'],
            ['name' => 'Papier toilette', 'category' => 'Hygiène'],
            ['name' => 'Serviettes en papier', 'category' => 'Épicerie'],
            ['name' => 'Fromage râpé', 'category' => 'Alimentation'],
            ['name' => 'Beurre doux', 'category' => 'Alimentation'],
            ['name' => 'Yaourt nature', 'category' => 'Alimentation'],
            ['name' => 'Eau gazeuse', 'category' => 'Boissons'],
            ['name' => 'Chocolat en tablette', 'category' => 'Épicerie'],
        ];
        $produit = $this->faker->randomElement($produits);
        return [
            //
            'supplier_id'=> Supplier::inRandomOrder()->first()->id,
            'name'=>$produit['name'],
            'reference'=>'REF-' . $this->faker->unique()->numberBetween(1000 , 9999),
            'category'=>$produit['category'],
            'purchase_price'=> $this->faker->randomFloat(2 ,100,25000),
            'selling_price'=>$this->faker->randomFloat(2 , 300 , 50000),
            'quantity'=> $this->faker->numberBetween(0,100),
            'alert_threshold'=>$this->faker->numberBetween(2 , 10),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
