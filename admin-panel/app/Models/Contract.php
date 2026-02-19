<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'file',
        'user_id',
        'ticket_id',
    ];

    /**
     * Get the user that owns the contract.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
