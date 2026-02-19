<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricings extends Model
{
    use HasFactory;

    public const SERVICE_CONSULTANT = 'CONSULTANT';
    protected $fillable = [
        'service_name',
        'description',
        'price'
    ];
}
