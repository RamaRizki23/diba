<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityFindingEvidence extends Model
{
    protected $table = 'security_finding_evidence';

    protected $fillable = ['security_finding_id', 'uploaded_by', 'original_name', 'path', 'mime_type', 'size'];

    public function finding(): BelongsTo
    {
        return $this->belongsTo(SecurityFinding::class, 'security_finding_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
