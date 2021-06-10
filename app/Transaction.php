<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'users_id', 'insurance_price', 'shipping_price', 'total_price','code', 'transaction_status'
    ];

    protected $hidden = [];

    public function user(){
        return $this->belongsTo(User::class, 'users_id','id');
    }
}
