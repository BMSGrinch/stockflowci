<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    //
    use HasFactory ;

    const UPDATED_AT = null ; 

    protected $fillable = [
        'product_id',
        'user_id',
        'movement_type',
        'quantity',
        'note',
    ];

    // Un mouvement de stock est pour un produit
    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    
    // Un mouvement de stock appartient à un utilisateur  
    public function user(){
        return $this->belongsTo(User::class);
    }

    
}
