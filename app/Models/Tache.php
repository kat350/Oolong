<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'start_date',
        'completee',
    ];

    protected $casts = [
        'completee' => 'boolean',
        'start_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}