<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'member_count',
        'member_emails',
        // Add more columns as needed
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'user_group_memberships', 'group_id', 'user_id');
    }
}
