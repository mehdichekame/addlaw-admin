<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class License extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'licenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'file',
        'size',
        'filename'
    ];

    protected $appends = [
        'file_url',
        'url'
    ];

    /**
     * Get the company that owns the license.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getFileUrlAttribute()
    {
        return Storage::disk('establish-company')->url($this->file);
    }

    public function getUrlAttribute()
    {
        return route('license_fetch_license_file', ['license' => $this->id]);
    }

}
