<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmitBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'identity_type',
        'partners',
        'need_consultant',
        'user_id',
        'legal_owner_national_id',
        'legal_owner_email',
        'legal_owner_ceo_name',
        'legal_owner_sign_is_collective',
        'legal_owner_sign_permitted',
        'trademark_owner_national_id',
        'trademark_owner_mobile_number',
        'trademark_owner_birthday',
        'trademark_owner_postal_code',
        'trademark_owner_email',
        'trademark_owner_phone_number',
        'intellectual_property_have_account',
        'intellectual_property_username',
        'intellectual_property_password',
    ];
}
