<?php

namespace App\Models\Area;

use App\Models\Accounting\TrainerAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'lat',
        'lon',
        'work_time',
    ];

    public function account()
    {
        return $this->belongsToMany(TrainerAccount::class, 'trainer_account_area', 'area_id' ,'account_id');
    }
}
