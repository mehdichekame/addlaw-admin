<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'collective',
        'role',
        'company_id',
    ];

    protected $casts = [
        'collective'=>'boolean'
    ];

    /**
     * Get the company that this sign belongs to.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
