<?php

namespace App\Models\Area;

use App\Models\Accounting\TrainerAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    CONST STATUS_NEW = 0;
    CONST STATUS_ACTIVE = 1;
    CONST STATUS_BLOCK = 2;
    CONST STATUS_LEAVE = 3;

    protected $fillable = [
        'id',
        'name',
        'description',
        'area_id',
        'status',
        'account_id',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(GroupCategory::class);
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function account()
    {
        return $this->belongsTo(TrainerAccount::class);
    }
}
