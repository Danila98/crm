<?php

namespace App\Models\Area;

use App\Models\Accounting\TrainerAccount;
use App\Models\Geo\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kiryanov\Filter\Filter\Filterable;

class Area extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'description',
        'city_id',
        'street',
        'house',
        'building',
        'lat',
        'lon',
    ];

    public function account()
    {
        return $this->belongsToMany(TrainerAccount::class, 'trainer_account_area', 'area_id', 'account_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
