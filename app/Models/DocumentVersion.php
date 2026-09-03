<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentVersion extends Model
{
    protected $fillable = [
        'coc_application_id', 'document_type', 'revision', 'path',
        'original_name', 'mime_type', 'file_size', 'uploaded_by_id', 'uploaded_by_type',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(CocApplication::class, 'coc_application_id');
    }
}
