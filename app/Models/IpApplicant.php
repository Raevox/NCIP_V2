<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ Import SoftDeletes

class IpApplicant extends Model
{
    use HasFactory, SoftDeletes; // ✅ Enable SoftDeletes

    protected $table = 'ip_applicants';

    protected $fillable = [
        'first_name',
        'last_name',
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
        'purpose',
        'purpose_others',
        'spouse_first_name',
        'spouse_last_name',
        'height_waiver',
        'educational_attainment',
        'degree_obtained',
        'father_name',
        'father_ipgroup',
        'father_origin',
        'mother_name',
        'mother_ipgroup',
        'mother_origin',
        'father_grandfather_name',
        'father_grandfather_ipgroup',
        'father_grandfather_origin',
        'father_grandmother_name',
        'father_grandmother_ipgroup',
        'father_grandmother_origin',
        'mother_grandfather_name',
        'mother_grandfather_ipgroup',
        'mother_grandfather_origin',
        'mother_grandmother_name',
        'mother_grandmother_ipgroup',
        'mother_grandmother_origin',
        'land_matter',
        'homestead_no',
        'lot_no',
        'issuance_date',
        'area',
        'location',
        'applicant_name',
        'date_accomplishment',
        'document_path',
        'document_text',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'census_date' => 'date',
        'height_waiver' => 'array',
        'land_matter' => 'boolean',
        'date_accomplishment' => 'date',
        'issuance_date' => 'date',
    ];
}
