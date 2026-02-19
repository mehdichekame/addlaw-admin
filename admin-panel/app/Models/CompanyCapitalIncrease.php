<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyCapitalIncrease extends Model
{
    use HasFactory;

    // Table name (optional if you follow Laravel's naming conventions)
    protected $table = 'company_capital_increase';

    // The attributes that are mass assignable
    protected $fillable = [
        'new_capital_amount',
        'nominal_value_per_share',
        'auditor_approval_letter',
        'edit_id',
    ];

    // Any additional configurations for the model can go here
}
