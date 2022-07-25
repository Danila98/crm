<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityStage extends Model
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
