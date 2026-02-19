<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UsedGiftCode
 */
class UsedGiftCode extends Model
{
    /**
     * @var string
     */
    protected $table = 'used_gift_code';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'gift_id',
        'package_id',
    ];

    /**
     * @var array
     */
    protected $hidden = ['updated_at'];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function gift()
    {
        return $this->belongsTo(GiftCode::class, 'gift_id');
    }

    /**
     * @return BelongsTo
     */
//    public function package()
//    {
//        return $this->belongsTo(Package::class, 'package_id');
//    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $subGiftCode = GiftCode::query()->find($model->gift_id);
            if ($subGiftCode->parent_id != null) {
                $parentGiftCode = GiftCode::query()->find($subGiftCode->parent_id);
                $parentGiftCode->used_count = $parentGiftCode->used_count + 1;
                $parentGiftCode->save();
            } else {
                $subGiftCode->used_count = $subGiftCode->used_count + 1;
                $subGiftCode->save();
            }
        });

    }
}
