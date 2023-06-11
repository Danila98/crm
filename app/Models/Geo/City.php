<?php

namespace App\Models\Geo;

use App\Models\Area\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kiryanov\Filter\Filter\Filterable;

class City extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'id',
        'name',
        'region_id',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Area::class);
    }
}
