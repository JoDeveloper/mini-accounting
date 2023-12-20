<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_movements', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->morphs("accountable");
            $table->morphs("reference");
            $table->enum('type', ['DEPOSIT', 'WITHDRAW']);
            $table->unsignedInteger('amount');
            $table->bigInteger('previous_balance');
            $table->bigInteger('balance');
            $table->json("data")->nullable();
            $table->string("notes")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique([
                'accountable_type',
                'accountable_id',
                "reference_id",
                "reference_type", "type"
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_movements');
    }
};
