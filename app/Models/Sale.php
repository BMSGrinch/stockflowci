<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
    ];

    protected $casts = [
        'total_amount'=>'decimal:2',
    ];

    // Une vente est faite par un utilisateur
    public function user(){
        return $this->belongsTo(User::class);
    }

    
    // Une vente a plusieurs items vendus
    public function saleItems(){
        return $this->hasMany(SaleItem::class);
    }
}
