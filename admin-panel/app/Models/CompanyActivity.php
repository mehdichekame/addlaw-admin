<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_subject',
        'description',
        'company_id',
        'attach_to_previous',
        'new_company_activity',
        'activity_detail',
        'edit_id',
        'requires_license',
        'license',
    ];
}
