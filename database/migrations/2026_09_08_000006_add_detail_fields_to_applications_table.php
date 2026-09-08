<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('architecture')->nullable();
            $table->string('server_location')->nullable();
            $table->string('pic')->nullable();
            $table->string('pic_phone')->nullable();
            $table->string('geoaccess')->nullable();
            $table->string('login_type')->nullable();
            $table->string('splp_connection')->nullable();
            $table->string('profile_status')->nullable();
            $table->string('repository_status')->nullable();
            $table->string('pse_status')->nullable();
            $table->string('pse_badge')->nullable();
            $table->string('api_availability')->nullable();
            $table->string('haki_status')->nullable();
            $table->unsignedSmallInteger('haki_year')->nullable();
            $table->decimal('total_investment', 15, 2)->nullable();
            $table->decimal('development_expansion_cost', 15, 2)->nullable();
            $table->string('application_type')->nullable();
            $table->string('license')->nullable();
            $table->string('platform_basis')->nullable();
            $table->string('e_service_type')->nullable();
            $table->string('user_type')->nullable();
            $table->string('developer_type')->nullable();
            $table->string('developer_name')->nullable();
            $table->string('personal_data')->nullable();
            $table->string('support_info')->nullable();
            $table->text('business_process')->nullable();
            $table->text('input_data')->nullable();
            $table->text('output_data')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'architecture', 'server_location', 'pic', 'pic_phone', 'geoaccess', 'login_type',
                'splp_connection', 'profile_status', 'repository_status', 'pse_status', 'pse_badge',
                'api_availability', 'haki_status', 'haki_year', 'total_investment',
                'development_expansion_cost', 'application_type', 'license', 'platform_basis',
                'e_service_type', 'user_type', 'developer_type', 'developer_name', 'personal_data',
                'support_info', 'business_process', 'input_data', 'output_data',
            ]);
        });
    }
};