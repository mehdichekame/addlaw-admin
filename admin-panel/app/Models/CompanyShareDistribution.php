<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyShareDistribution extends Model
{
    use HasFactory;

    protected $table = 'company_share_distribution';

    protected $fillable = [
        'type',
        'excellent_type',
        'company_id',
        'share_count',
        'regular_share_count',
        'noname_share_count',
        'excellent_share_count',
        'regular_share_description',
        'noname_share_description',
        'excellent_share_description',
        'excellent_features',
        'edit_id',
    ];
    /**
     * Get the company that owns the finance.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getTypeAttribute($type)
    {
        return explode(',', $type);
    }
}
