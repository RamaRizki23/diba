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
        'architecture', 'server_location', 'pic', 'pic_phone', 'geoaccess', 'login_type',
        'splp_connection', 'profile_status', 'repository_status', 'pse_status', 'pse_badge',
        'api_availability', 'haki_status', 'haki_year', 'total_investment',
        'development_expansion_cost', 'application_type', 'license', 'platform_basis',
        'e_service_type', 'user_type', 'developer_type', 'developer_name', 'personal_data',
        'support_info', 'business_process', 'input_data', 'output_data',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'haki_year' => 'integer',
            'development_cost' => 'decimal:2',
            'total_investment' => 'decimal:2',
            'development_expansion_cost' => 'decimal:2',
        ];
    }
}
