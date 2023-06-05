<?php

namespace App\Models\Area;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityCategory extends Model
{
    use HasFactory;

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

}
