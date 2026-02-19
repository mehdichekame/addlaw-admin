<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = [
        'product_id',
        'file_name',
        'file_url',
        'file_type',
        'downloaded',
        'expired_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
