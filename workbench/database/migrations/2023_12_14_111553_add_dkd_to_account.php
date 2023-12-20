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
        Schema::table('account_movements', function (Blueprint $table) {
            $table->unique([
                'accountable_type',
                'accountable_id',
                "reference_id",
                "reference_type", "type"
            ], "unique_identifiers");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account', function (Blueprint $table) {
            //
        });
    }
};
