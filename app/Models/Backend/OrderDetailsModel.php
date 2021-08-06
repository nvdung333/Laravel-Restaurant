<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailsModel extends Model
{
    use HasFactory;

    protected $table = 't_orderdetails';
    protected $primaryKey = 'id';

    public function orderdetails_order_modelfunc()
    {
        return $this->belongsTo(OrdersModel::class);
    }
}
