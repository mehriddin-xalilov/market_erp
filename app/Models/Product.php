<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'description',
        'price',
        'cost_price',
        'current_stock',
        'reorder_level',
        'unit',
        'status',
    ];
    protected $hidden = [
        'cost_price',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function warehouseStocks(): HasMany
    {
        return $this->hasMany(WarehouseStock::class);
    }
}
