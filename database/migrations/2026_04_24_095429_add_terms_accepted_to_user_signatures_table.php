<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_vacations';

    public function up(): void
    {
        Schema::connection('mysql_vacations')->table('user_signatures', function (Blueprint $table) {
            $table->string('signature_url')->nullable()->change();
            $table->timestamp('terms_accepted_at')->nullable()->after('signature_url');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql_vacations')->table('user_signatures', function (Blueprint $table) {
            $table->dropColumn('terms_accepted_at');
            $table->string('signature_url')->nullable(false)->change();
        });
    }
};
