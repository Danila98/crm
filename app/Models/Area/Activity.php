<?php

namespace App\Models\Area;

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
        'activity_id' => 'activityId',
    ];
}
