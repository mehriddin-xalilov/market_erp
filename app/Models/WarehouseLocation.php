<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WarehouseLocation extends Model
{
    protected $table = 'warehouse_locations';
    protected $fillable = [
        'code',
        'section',
        'rack',
        'shelf',
        'notes',
        'status',
    ];



    public function warehouseStocks(): HasMany
    {
        return $this->hasMany(WarehouseStock::class);
    }

}
