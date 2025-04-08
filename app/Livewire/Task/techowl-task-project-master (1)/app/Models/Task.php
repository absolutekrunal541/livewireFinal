<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'assigned_to', 'status'];
    // Task belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
