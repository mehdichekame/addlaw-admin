<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'dest_id',
        'user_id',
        'status'
    ];
    protected $appends = [
        'service_name'
    ];


    public function getServiceNameAttribute()
    {
        if ($this->type === 'App\Models\Company'){
            $company = Company::findOrFail($this->dest_id);
            return 'ESTABLISH_COMPANY';
        }
        if ($this->type === 'App\Models\CompanyEdit'){
            $company = Company::findOrFail($this->dest_id);
            return 'EDIT_COMPANY';
        }
        if ($this->type === 'App\Models\Contract'){
            $contract = Contract::findOrFail($this->dest_id);
            if ($contract->type === 'create'){
                return 'CREATE_CONTRACT';
            }
            return 'CHECK_CONTRACT';
        }
    }
}
