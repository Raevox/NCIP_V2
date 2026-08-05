<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    use HasFactory;

    protected $table = 'accomplishments';

    protected $fillable = [
        'title',
        'description',
        'date_label',
        'image',
        'extra_images',
        'layout_type',
        'year_group',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'extra_images' => 'array',
        'is_active'    => 'boolean',
        'layout_type'  => 'integer',
        'sort_order'   => 'integer',
    ];

    // Scope for active accomplishments only
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
