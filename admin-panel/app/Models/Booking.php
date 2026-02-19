<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        "consultant_availability_id",
        "email",
        "phone",
        "first_name",
        "last_name",
        "type",
        "description"
    ];

    // Define relationships
    public function consultantAvailability()
    {
        return $this->belongsTo(ConsultantAvailability::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
