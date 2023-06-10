<?php

namespace App\Models\Area;

use App\Models\Accounting\TrainerAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kiryanov\Filter\Filter\Filterable;

class Area extends Model
{
    use HasFactory, Filterable;

    public function account()
    {
        return $this->belongsToMany(TrainerAccount::class, 'trainer_account_area', 'area_id' ,'account_id');
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
