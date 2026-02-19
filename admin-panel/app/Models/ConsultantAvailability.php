<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class ConsultantAvailability extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_time',
        'end_time',
        'capacity'
    ];

    protected $dates = [
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time'=>'datetime:Y-m-d H:i:s',
        'end_time'=>'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'jalali_start',
        'jalali_end',
        'duration',
    ];
    // Relationship with bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }


    public function getJalaliStartAttribute()
    {
        return Jalalian::forge(strtotime($this->start_time))->format('%A, %d %B %y');
    }


    public function getJalaliEndAttribute()
    {
        return Jalalian::forge(strtotime($this->end_time))->format('%A, %d %B %y');
    }


    public function getDurationAttribute()
    {
        try {
            $first_date = new DateTime($this->start_time);
            $second_date = new DateTime($this->end_time);
            $result = $first_date->diff($second_date);
            return $result->format('%H:%i:%s');
        } catch (\Exception $e) {
        }
        return '';
    }

}
