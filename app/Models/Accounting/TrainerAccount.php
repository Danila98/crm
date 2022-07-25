<?php

namespace App\Models\Accounting;

use App\Models\Area\Area;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerAccount extends Model
{
    use HasFactory;

    const DEFAULT_MAX_PUPILS = 10;

    protected $fillable = [
        'id',
        'user_id',
        'pupils',
        'max_pupils' => 'maxPupils',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function area()
    {
        return $this->belongsToMany(Area::class, 'trainer_account_area', 'account_id' ,'area_id');
    }
}
