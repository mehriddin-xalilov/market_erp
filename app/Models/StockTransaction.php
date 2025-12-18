<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $table = 'stock_transactions';
    protected $fillable = [
        'warehouse_location_id',
        'product_id',
        'quantity',
        'type',
        'unit_price',
        'total_price',
        'user_id',
        'notes',
        'reference_no',
    ];

    public function warehouseLocation()
    {
        return $this->belongsTo(WarehouseLocation::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
