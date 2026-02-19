<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyEdit extends Model
{
    protected $fillable = [
        'company_id',
        'national_id',
        'people_count',
        'newsletter_id',
        'new_postal_code',
        'substitute_inspector_type',
        'inspector_type',
        'edits',
        'ticket_id',
    ];

    protected $casts = [
        'edits' => 'array',
    ];

    protected $appends = [
        'names'
    ];

    // Relationship with Company model (if exists)
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with Newsletter model (if exists)
    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class);
    }

    public function companyLiquidation()
    {
        return $this->hasOne(CompanyLiquidation::class, 'edit_id');
    }

    public function approveFinancialBalance()
    {
        return $this->hasOne(ApproveFinancialBalance::class, 'edit_id');
    }

    public function changeCompanyRepresentative()
    {
        return $this->hasOne(ChangeCompanyRepresentative::class, 'edit_id');
    }

    public function companyActivity()
    {
        return $this->hasOne(CompanyActivity::class, 'edit_id');
    }

    public function companyCapitalIncrease()
    {
        return $this->hasOne(CompanyCapitalIncrease::class, 'edit_id');
    }

    public function companyCapitalPayment()
    {
        return $this->hasOne(CompanyCapitalPayment::class, 'edit_id');
    }


    public function companyShareDistribution()
    {
        return $this->hasOne(CompanyShareDistribution::class, 'edit_id');
    }

    public function getNamesAttribute()
    {
        return CompanyName::query()->where('company_id',$this->company_id)->where('type','EDIT')->get();
    }
}
