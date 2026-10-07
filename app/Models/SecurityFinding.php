<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecurityFinding extends Model
{
    use HasFactory;

    public const STATUSES = ['Baru', 'Dalam Penanganan', 'Menunggu Verifikasi', 'Selesai'];

    public const SEVERITIES = ['High', 'Medium', 'Low'];

    protected $fillable = [
        'reference_code', 'application_id', 'reporter_id', 'application_name', 'application_url',
        'owner', 'title', 'finding_type', 'category', 'severity', 'source', 'found_at', 'description',
        'impact', 'recommendation', 'status', 'deadline', 'pic_name', 'pic_email', 'internal_note',
        'follow_up', 'notified_at', 'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'found_at' => 'datetime',
            'deadline' => 'date',
            'notified_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function evidence(): HasMany
    {
        return $this->hasMany(SecurityFindingEvidence::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(SecurityFindingActivity::class)->latest();
    }

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, fn (Builder $q, string $value) => $q->where('status', $value))
            ->when($filters['severity'] ?? null, fn (Builder $q, string $value) => $q->where('severity', $value))
            ->when($filters['type'] ?? null, fn (Builder $q, string $value) => $q->where('finding_type', $value))
            ->when($filters['owner'] ?? null, fn (Builder $q, string $value) => $q->where('owner', $value))
            ->when($filters['search'] ?? null, function (Builder $q, string $value): void {
                $q->where(function (Builder $q) use ($value): void {
                    $q->where('reference_code', 'like', '%'.$value.'%')
                        ->orWhere('title', 'like', '%'.$value.'%')
                        ->orWhere('application_name', 'like', '%'.$value.'%')
                        ->orWhere('application_url', 'like', '%'.$value.'%')
                        ->orWhere('description', 'like', '%'.$value.'%');
                });
            });
    }
}
