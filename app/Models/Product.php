<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'name',
        'cost_price',
        'description',
        'sku',
        'stock',
        'status',
        'current_stock',
        'reorder_level',
        'unit',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
