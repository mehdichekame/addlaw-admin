<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'department',
        'service',
        'model_id',
        'status',
        'user_id'
    ];

    protected $appends = [
        'files'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function getFilesAttribute()
    {
//        dd(Message::query()
//            ->select('attachments.file')
//            ->join('attachments', 'attachments.message_id', 'messages.id')
//            ->get(),Attachment::all());
        return Message::query()
            ->select('attachments.file','attachments.original_file_name')
            ->join('attachments', 'attachments.message_id', 'messages.id')
            ->where('messages.ticket_id',$this->id)
            ->get();

    }
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
}
