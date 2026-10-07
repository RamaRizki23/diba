<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityFindingActivity extends Model
{
    protected $table = 'security_finding_activities';

    protected $fillable = ['security_finding_id', 'user_id', 'event', 'from_status', 'to_status', 'note'];

    public function finding(): BelongsTo
    {
        return $this->belongsTo(SecurityFinding::class, 'security_finding_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
