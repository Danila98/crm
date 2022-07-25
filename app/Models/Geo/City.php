<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kiryanov\Filter\Filter\Filterable;

class City extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'id',
        'name',
        'region_id',
    ];

}
