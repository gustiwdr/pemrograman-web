<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mysql';
    protected $table = 'orders';

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function orderItem() {
        return $this->hasMany(OrderItem::class);
    }
}
