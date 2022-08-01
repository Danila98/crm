<?php

namespace App\Models\Area;

use App\Models\Accounting\TrainerAccount;
use Egulias\EmailValidator\Result\Reason\ExceptionFound;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Exception\NotFoundException;

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
