<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id',
    ];

        protected $casts = [
        'completed' => 'boolean',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
