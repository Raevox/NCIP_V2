<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';

    protected $fillable = [
        'name',
        'logo',
        'sector',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Scope: active only */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Scope: government sector */
    public function scopeGovernment($query)
    {
        return $query->where('sector', 'government');
    }

    /** Scope: private sector */
    public function scopePrivate($query)
    {
        return $query->where('sector', 'private');
    }
}
