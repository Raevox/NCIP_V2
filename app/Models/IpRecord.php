<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ip_records';

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'sex',
        'ip_group',
        'birth_date',
        'origin_province',
        'origin_municipality',
        'origin_barangay',
        'province',
        'municipality',
        'barangay',
        'census_date',
        'civil_status',
        'religion',
        'ncip_number',
        'occupation',
        'income',
        'pwd',
        'educational_level',
        'degree',
        'image',
        'is_archived',
    ];

    protected $casts = [
        'birth_date' => 'date:Y-m-d',
        'census_date' => 'date:Y-m-d',
        'is_archived' => 'boolean',
        'income' => 'float',
    ];

    // -----------------------------
    // SCOPES
    // -----------------------------
    
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    // -----------------------------
    // ACCESSORS
    // -----------------------------

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    // Optional: return image URL or default placeholder
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('images/default-profile.png');
    }

    // -----------------------------
    // RELATIONSHIPS (Placeholders)
    // -----------------------------

    // If IPGroup is a separate table
    public function group()
    {
        return $this->belongsTo(IPGroup::class, 'ip_group', 'id');
    }

    // If Province/Municipality/Barangay are separate tables
    public function provinceInfo()
    {
        return $this->belongsTo(Province::class, 'province', 'id');
    }

    public function municipalityInfo()
    {
        return $this->belongsTo(Municipality::class, 'municipality', 'id');
    }

    public function barangayInfo()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }
}
