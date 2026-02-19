<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyReport extends Model
{
    use HasFactory;

    protected $table = 'company_reports';

    protected $fillable = [
        'report_subject',
        'report_description',
        'report_file',
    ];
}
