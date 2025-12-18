<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseStock extends Model
{
    protected $table = 'warehouse_stock';
    protected $fillable = [
        'warehouse_location_id',
        'product_id',
        'quantity',
        'last_updated_at',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function warehouseLocation()
    {
        return $this->belongsTo(WarehouseLocation::class);
    }
}
