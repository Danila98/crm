<?php

namespace App\Models\Area;

use App\Models\Accounting\TrainerAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    CONST PLANED = 1;
    CONST CANCELED = 2;
    CONST END = 3;

    protected $fillable = [
        'id',
        'name',
        'start',
        'end',
        'status',
        'area_id',
        'account_id',
        'group_id',
        'category_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function category()
    {
        return $this->belongsTo(ActivityCategory::class, 'category_id');
    }

    public function account()
    {
        return $this->belongsTo(TrainerAccount::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
