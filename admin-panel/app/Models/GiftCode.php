<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class GiftCode
 *
 * @property mixed name
 * @property mixed started_at
 * @property Carbon expired_at
 * @property null total_count
 * @property int discount_percentage
 * @property int owner
 * @property null package_ids
 * @property null user_ids
 * @property mixed|string code
 * @property int available_count
 * @property mixed id
 * @property int parent_id
 */
class GiftCode extends Model
{
    public const GIFT_CODE_WITH_CHILDREN = 'temp_parent_code';

    public const STORAGE_BUCKET = 'gift-code';

    /**
     * @var string
     */
    protected $table = 'gift_code';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'started_at',
        'expired_at',
        'total_count',
        'discount_percentage',
        'owner',
        'package_ids',
        'user_ids',
        'code',
        'parent_id',
    ];

    /**
     * @var array
     */
    protected $hidden = ['updated_at'];

    protected $casts = [
        'discount_percentage' => 'int',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'started_at',
        'expired_at',
    ];

    protected $appends = [
        'available_count',
        'gift_code_url',
    ];

    /**
     * @return mixed
     */
    public function getPackageIdsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setPackageIdsAttribute($value)
    {
        if ($value != null) {
            $this->attributes['package_ids'] = json_encode($value);
        } else {
            $this->attributes['package_ids'] = null;
        }
    }

    /**
     * @return mixed
     */
    public function getUserIdsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setUserIdsAttribute($value)
    {
        if ($value != null) {
            $this->attributes['user_ids'] = json_encode($value);
        } else {
            $this->attributes['user_ids'] = null;
        }
    }

    /**
     * @return int
     */
    public function getAvailableCountAttribute()
    {
        $all = $this->total_count;
        $used = UsedGiftCode::query()->where('gift_id', $this->id)->count();

        $childGift = null;
        if (empty($this->parent_id)) {
            $childGift = GiftCode::query()->where('parent_id', $this->id)->get();

            foreach ($childGift as $item) {
                $all += (int) $item->total_count;
                $used += UsedGiftCode::query()->where('gift_id', $item->id)->count();
            }
        }

        return $all < 0 ? 100 : ($all - $used);
    }

    /**
     * @return null|string
     */
    public function getGiftCodeUrlAttribute()
    {
        if (Str::contains($this->code, '.csv')) {
            return Storage::disk('s3')->url('/salot/'.$this->code);
            //            return env('MINIO_CLIENT_ENDPOINT') . "/" . self::STORAGE_BUCKET . "/" . $this->code;
        } else {
            return null;
        }
    }

    public function usedGiftCode()
    {
        return $this->hasMany(UsedGiftCode::class, 'gift_id');
    }
}
