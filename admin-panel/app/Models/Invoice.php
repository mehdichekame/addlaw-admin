<?php

namespace App\Models;

use App\Services\GiftCodeHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpMonsters\Larapay\Models\LarapayTransaction;
use PhpMonsters\Larapay\Payable;

/**
 * Class Invoice
 *
 * @property int paid
 */
class Invoice extends Model
{


    use Payable;

    public const SOURCE_BOOK = 'booking';
    public const SOURCE_PRODUCT = 'product';
    public const SOURCE_ESTABLISH = 'App\Models\Company';
    public const SOURCE_EDIT = 'App\Models\CompanyEdit';

    public static $source_map = [
        self::SOURCE_BOOK =>'booking',
        self::SOURCE_PRODUCT =>'contract',
        self::SOURCE_ESTABLISH =>'establishment',
        self::SOURCE_EDIT =>'edit_company',
    ];

    const VAT = 9;

    const TO_RIAL = 10;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'vat',
        'total',
        'package_id',
        'booking_id',
        'paid',
        'gift_code_id',
        'source',
        'model_id',
        'email',
        'phone',
        'first_name',
        'last_name',
        'step',
        'percentage',
        'service_name'
    ];

    /**
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * @var array
     */
    protected $casts = [
        'paid' => 'bool',
        'amount' => 'int',
        'vat' => 'string',
        'total' => 'int',
    ];

    protected $appends = [
        'dest_url',
        'payable',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->hasOne(LarapayTransaction::class, 'model_id');
    }

    public function giftCode()
    {
        return $this->hasOne(GiftCode::class, 'id', 'gift_code_id');
    }


    public function getAmount()
    {
        if (!$this->giftCode) {
            return intval($this->total);
        }
        $service_name = self::$source_map[(string)$this->source];
        $data = [
            'service_name' => $service_name,
            'model_id' => $this->model_id,
            'price' => $this->total
        ];
        $result = GiftCodeHelper::isValid($this->giftCode, $data);
        return $result['price'];
    }

    public function getDestUrlAttribute()
    {
        if ($this->paid) {
            switch ($this->source) {
                case Invoice::SOURCE_BOOK:
                    return route('home-page-web');
                case Invoice::SOURCE_PRODUCT:
                    return route('contracts-list-web');
                case Invoice::SOURCE_ESTABLISH:
                    return route('establish-company-web', ['company_id' => $this->model_id, 'step' => 2]);
                case Invoice::SOURCE_EDIT:
                    return route('edit-company-web', ['edit_id' => $this->model_id]);
                default:
                    return route('home-page-web');
            }
        }
        switch ($this->source) {
            case Invoice::SOURCE_BOOK:
                return route('home-page-web');
            case Invoice::SOURCE_PRODUCT:
                return route('contracts-list-web');
            case Invoice::SOURCE_ESTABLISH:
                return route('establish-company-web', ['company_id' => $this->model_id, 'step' => 1]);
            case Invoice::SOURCE_EDIT:
                return route('edit-company-web', ['edit_id' => $this->model_id]);
            default:
                return route('home-page-web');
        }

    }

    public function getPayableAttribute()
    {
        if (!in_array($this->source, [
            Invoice::SOURCE_ESTABLISH,
            Invoice::SOURCE_EDIT,
        ])) {
            if ($this->paid) {
                return 0;
            }
            return $this->amount;
        }
        if ($this->step == 1 && !$this->paid) {
            return $this->amount;
        }
        if ($this->step == 2 && $this->paid) {
            return 0;
        }
        return $this->total - $this->amount;

    }
}
