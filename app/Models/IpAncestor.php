<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpAncestor extends Model
{
    protected $fillable = [
        'applicant_id',   // FK papunta sa IpApplicant
        'parent_type',    // father / mother
        'relationship',   // Grandfather / Grandmother / etc.
        'first_name',
        'last_name',
        'origin',
        'ipgroup',
    ];
}
