<?php

namespace App\Models\Area;

use App\Models\Accounting\TrainerAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    public const PLANED = 1;
    public const  CANCELED = 2;
    public const  END = 3;

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
