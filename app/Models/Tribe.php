<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tribe extends Model
{
    use HasFactory;

    protected $table = 'tribes';

    protected $fillable = [
        'name',
        'description',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active tribes only
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
