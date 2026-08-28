<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    use HasFactory;

    public const TYPES = [
        'perangkat_daerah' => 'Perangkat Daerah',
        'layanan' => 'Layanan',
        'sektor' => 'Sektor',
        'bahasa_pemrograman' => 'Bahasa Pemrograman',
        'framework' => 'Framework',
        'database' => 'Database',
        'operating_system' => 'Operating System',
    ];

    protected $table = 'master_data';

    protected $fillable = ['type', 'name'];
}
