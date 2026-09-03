<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CocApplication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'step1',
        'step2',
        'step3',
        'step4',
        'applicant_picture',
        // 'signature' removed: field no longer used for uploads in Step 5
        'tribal_certificate',
        'birth_certificate',
        'genealogy_form',
        'tribe',
        'status',
        'remarks',
        'index_status',
        'genealogy_status',
        'documents_status',
        'submitted_at',
        'coc_status',
        'approved_by',
        'approved_at',
        'classification',
    ];

    protected $casts = [
        'step1' => 'array',
        'step2' => 'array',
        'step3' => 'array',
        'step4' => 'array',
        'submitted_at' => 'datetime',
        'created_at' => 'datetime',
        'remarks' => 'array',
        'classification' => 'array',
        'coc_status' => 'string',
    ];

    // 🔹 Relationship: applicant (IP Account)
    public function applicant()
    {
        return $this->belongsTo(IpAccount::class, 'user_id', 'id');
    }

    public function documentVersions()
    {
        return $this->hasMany(DocumentVersion::class)->orderByDesc('revision');
    }

    // 🔹 Relationship: applicant registration
    public function applicantRegistration()
    {
        return $this->hasOne(ApplicantRegistration::class, 'ip_account_id', 'user_id');
    }

    // 🔹 Relationship: staff/admin who approved
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    // 🔹 Helper: Purpose (if saved in step1 or step2)
    public function getPurposeAttribute()
    {
        return $this->step1['purpose'] ?? $this->step2['purpose'] ?? null;
    }

    // 🔹 Returned Section Logic
    public function getReturnedSections(): array
    {
        $sections = [];
        if ($this->index_status === 'returned') $sections[] = 'index';
        if ($this->genealogy_status === 'returned') $sections[] = 'genealogy';
        if ($this->documents_status === 'returned') $sections[] = 'documents';
        return $sections;
    }

    public function countReturnedSections(): int
    {
        return count($this->getReturnedSections());
    }

    public function getReturnedSteps(): array
    {
        $map = [
            'index' => [1, 2],
            'genealogy' => [3, 4],
            'documents' => [5],
        ];
        $steps = [];
        foreach ($this->getReturnedSections() as $section) {
            $steps = array_merge($steps, $map[$section]);
        }
        return $steps;
    }

    public function getNextReturnedStep(): ?int
    {
        $steps = $this->getReturnedSteps();
        return !empty($steps) ? min($steps) : null;
    }
  public function ipRecord()
{
    return $this->hasOne(IpRecord::class, 'user_id', 'user_id');
}



}
