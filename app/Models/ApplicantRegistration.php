<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'contact',
        'address',
        'province_code',
        'province_name',
        'municipality_code',
        'municipality_name',
        'barangay_code',
        'barangay_name',
        'tribe',
        'leader',
        'password',
        'status',
        'document_path',
        'ip_account_id', // 🔹 importante para sa relationship
    ];

    // 🔹 Relationship sa IP Account
    public function ipAccount()
    {
        return $this->belongsTo(IpAccount::class, 'ip_account_id', 'id');
    }

    // 🔹 Latest COC Application ng user
    public function latestCocApplication()
    {
        return $this->hasOne(CocApplication::class, 'user_id', 'ip_account_id')->latestOfMany();
    }

    // 🔹 All COC Applications ng user
    public function cocApplications()
    {
        return $this->hasMany(CocApplication::class, 'user_id', 'ip_account_id');
    }
}
