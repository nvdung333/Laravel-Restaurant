<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    use HasFactory;

    protected $table = 't_orders';
    protected $primaryKey = 'id';

    public function order_orderdetails_modelfunc()
    {
        return $this->hasMany(OrderDetailsModel::class);
    }
}
