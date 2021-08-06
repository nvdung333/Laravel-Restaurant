<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model
{
    use HasFactory;

    protected $table = 't_categories';
    protected $primaryKey = 'id';

    public function category_products_modelfunc()
    {
        return $this->hasMany(ProductsModel::class);
    }
}
