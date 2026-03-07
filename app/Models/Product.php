<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory ;
    //
    protected $fillable = [
        'supplier_id',
        'name',
        'reference',
        'category',
        'purchase_price',
        'selling_price',
        'quantity',
        'alert_threshold',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active'=>'boolean',
    ];

    // Un produit appartient à un fournisseur
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    // Un produit a plusieurs lignes de vente
    public function salesItems(){
        return $this->hasMany(SaleItem::class);
    }

    //Un produit a plusieurs mouvements de stock
    public function stockMovements(){
        return $this->hasMany(StockMovement::class);
    }
}
