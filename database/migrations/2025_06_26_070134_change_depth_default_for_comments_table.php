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
        Schema::table('comments', function (Blueprint $table) {
            // Change the default value of 'depth' to 1
            $table->integer('depth')->default(1)->change();

            // Ensure that the 'depth' column is not nullable
            $table->integer('depth')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Revert the 'depth' column to its previous state
            $table->integer('depth')->default(0)->change();

            // Ensure that the 'depth' column can be nullable again
            $table->integer('depth')->nullable()->change();
        });
    }
};
