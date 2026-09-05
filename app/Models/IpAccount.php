<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable; 
use App\Models\IpApplicant;
use App\Models\IpRecord;
use App\Models\CocApplication; 

class IpAccount extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'ip_accounts';

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
        'document_text',    
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔹 Relationship to applications (IpApplicants table)
    public function application()
    {
        return $this->hasOne(IpApplicant::class, 'name', 'name');
    }

    // 🔹 Relationship to records (IpRecords table)
    public function record()
    {
        return $this->hasOne(IpRecord::class, 'name', 'name');
    }

    // 🔹 Relationship to CoC applications
    public function cocApplications()
    {
        return $this->hasMany(CocApplication::class, 'user_id', 'id');
    }

    // 🔹 Convenience relationship for latest CoC application
    public function latestCoCApplication()
    {
        return $this->hasOne(CocApplication::class, 'user_id', 'id')->latestOfMany();
    }

    // 🔹 Full name accessor
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
