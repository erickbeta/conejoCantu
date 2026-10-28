<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('payer_email')->nullable()->after('user_id');
            $table->string('claim_token', 64)->nullable()->unique()->after('mercadopago_id');
            $table->decimal('amount', 10, 2)->nullable()->after('plan_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['payer_email', 'claim_token', 'amount']);
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};

