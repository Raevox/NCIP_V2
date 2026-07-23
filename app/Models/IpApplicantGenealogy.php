<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpApplicantGenealogy extends Model
{
    use HasFactory;

    protected $table = 'ip_applicants_genealogy'; // table name

    protected $fillable = [
        'ip_applicant_id',
        'relation',
        'first_name',
        'last_name',
        'origin',
        'ip_group',
    ];

    public function ipApplicant()
    {
        return $this->belongsTo(IpApplicant::class, 'ip_applicant_id');
    }
}
