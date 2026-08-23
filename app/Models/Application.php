<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'owner', 'service', 'sector', 'status', 'year', 'url',
        'language', 'framework', 'database', 'operating_system', 'server',
        'description', 'operational_unit', 'integrations', 'development_cost',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'development_cost' => 'decimal:2',
        ];
    }
}
