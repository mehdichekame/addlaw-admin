<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RealIdentity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'national_code',
        'address',
        'postal_code',
        'birthdate',
        'phone_number',
        'verified_at',
        'fathers_name',
        'first_name',
        'last_name',
        'data',
    ];

    protected $dates = ['deleted_at'];

    public function shareholders()
    {
        return $this->hasMany(Shareholder::class);
    }

    public function inspectors()
    {
        return $this->hasMany(Inspector::class);
    }

    public function companyBoards()
    {
        return $this->hasMany(CompanyBoard::class);
    }

}
