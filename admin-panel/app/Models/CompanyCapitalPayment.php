<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCapitalPayment extends Model
{
    use HasFactory;

    protected $table = 'company_capital_payment';

    protected $fillable = [
        'registered_capital_amount',
        'paid_up_capital_amount',
        'bank_certificate_image',
        'edit_id',
    ];
}
