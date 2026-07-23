<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantGenealogy extends Model
{
    use HasFactory;

    protected $table = 'applicant_genealogy'; // table name

    protected $fillable = [
        'applicant_id',
        'relation',
        'first_name',
        'last_name',
        'origin',
        'ip_group',
    ];

    public function applicant()
    {
        return $this->belongsTo(ApplicantRegistration::class, 'applicant_id');
    }
    
}
