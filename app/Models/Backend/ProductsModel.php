<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory;

    protected $table = 't_products';
    protected $primaryKey = 'id';

    public function products_category_modelfunc()
    {
        return $this->belongsTo(CategoriesModel::class);
    }
}
