<?php

namespace App\Models\Area;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'time',
        'is_end' => 'isEnd',
        'activity_id' => 'activityId',
    ];
}
