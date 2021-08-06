<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantsModel extends Model
{
    use HasFactory;

    protected $table = 't_restaurants';
    protected $primaryKey = 'id';
}
