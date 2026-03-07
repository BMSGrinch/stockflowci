<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    //
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'unit_price'=>'decimal:2'
    ];

    public $timestamps = false; // Ca faisait chier la migration des tables donc j'ai mis à false

    // Un item de vente appartient à une vente 
    public function sale(){
        return $this->belongsTo(Sale::class);
    }
    
    
    // Un item de vente est un produit  
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
