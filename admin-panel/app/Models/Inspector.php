<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Inspector extends Model
{
    protected $fillable = [
        'dest_id',
        'type',
        'source_id',
        'real_id',
        'attorney_id',
    ];

    public function destinationCompany()
    {
        return $this->belongsTo(Company::class, 'dest_id');
    }

    public function sourceCompany()
    {
        return $this->belongsTo(Company::class, 'source_id');
    }

    public function realIdentity()
    {
        return $this->belongsTo(RealIdentity::class,'real_id');
    }

    public function attorney()
    {
        return $this->belongsTo(RealIdentity::class,'attorney_id');
    }
}
