<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'event_day',
        'event_month',
        'event_year',
        'event_title',
        'event_time_from',
        'event_time_to',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
