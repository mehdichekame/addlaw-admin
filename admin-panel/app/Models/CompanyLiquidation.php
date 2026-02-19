<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyLiquidation extends Model
{
    use HasFactory;

    protected $table = 'company_liquidation';

    // Define the fillable attributes
    protected $fillable = [
        'edit_id',
        'national_id',
        'phone_number',
        'birth_date',
        'postal_code',
        'mobile_number',
        'email',
        'liquidation_location',
        'liquidation_location_postal_code',
    ];
}
