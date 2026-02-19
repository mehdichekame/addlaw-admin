<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    public static $company_type_map = [
        'public-stock' => 'سهامی عام',
        'private-stock' => 'سهامی خاص',
        'limited-liability' => 'مسئولیت محدود'
    ];

    protected $fillable = [
        'name',
        'type',
        'national_id',
        'company_topic',
        'establish_date',
        'address',
        'postal_code',
        'number',
        'activity_duration',
        'duration_type',
        'company_topic',
        'online_signature',
        'registration_number',
        'company_type',
        'people_count',
        'ticket_id',
        'signature_holder_company_id',
        'signature_holder_real_id',
        'newsletter_id',
        'user_id',
    ];

    protected $casts = [
        'online_signature' => 'boolean',
        'establish_date' => 'date',
    ];

    protected $dates = ['establish_date', 'activity_duration', 'deleted_at'];


    protected $appends = [
        'sign'
    ];

    public function signatureHolderReal()
    {
        return $this->belongsTo(RealIdentity::class, 'signature_holder_real_id');
    }

    public function signatureHolderCompany()
    {
        return $this->belongsTo(Company::class, 'signature_holder_company_id');
    }

    public function getSignAttribute()
    {
        $result = [];
        $sings = $this->signCompany;
        foreach ($sings as $sing) {
            $result[$sing->type]['data'][] = $sing;
            $result[$sing->type]['collective'] = $sing->collective;
        }
        return $result;
    }

    public function signCompany()
    {
        return $this->hasMany(SignCompany::class);
    }

    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class);
    }

    public function companyFinance()
    {
        return $this->hasOne(CompanyFinance::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function shareholders()
    {
        return $this->hasMany(Shareholder::class, 'source_id');
    }

    public function shares()
    {
        return $this->hasMany(Shareholder::class, 'dest_id');
    }

    public function companyBoards()
    {
        return $this->hasMany(CompanyBoard::class, 'source_id');
    }

    public function boards()
    {
        return $this->hasMany(CompanyBoard::class, 'dest_id');
    }

    public function inspectors()
    {
        return $this->hasMany(Inspector::class, 'dest_id');
    }

    public function inspectedCompanies()
    {
        return $this->hasMany(Inspector::class, 'source_id');
    }

    public function licenses()
    {
        return $this->hasOne(License::class, 'company_id');
    }

    public function names()
    {
        return $this->hasMany(CompanyName::class);
    }

    public function companyNames()
    {
        return $this->hasMany(CompanyName::class);
    }

    public function invoice()
    {
        return $this->morphMany(Invoice::class, 'model', 'source');
    }

}
