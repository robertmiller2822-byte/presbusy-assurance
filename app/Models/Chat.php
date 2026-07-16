<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['visitor_name', 'visitor_email', 'status'];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}