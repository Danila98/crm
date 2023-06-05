<?php

namespace App\Models\Area;

use App\Models\Accounting\TrainerAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Exception\NotFoundException;

class Group extends Model
{
    use HasFactory;

    public const  STATUS_NEW = 0;
    public const  STATUS_ACTIVE = 1;
    public const  STATUS_BLOCK = 2;
    public const  STATUS_LEAVE = 3;

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

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public static function mapStatuses(int $status) : string
    {
        $map = [
            self::STATUS_NEW => 'Новая',
            self::STATUS_ACTIVE => 'Активная',
            self::STATUS_BLOCK => 'Заблокированна',
            self::STATUS_LEAVE => 'В отпуске',
        ];

        if(isset($map[$status])){

            return $map[$status];
        }else{
            throw new NotFoundException();
        }

    }
}
