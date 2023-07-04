<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
                // 1. Create new column
            // You probably want to make the new column nullable
            $table->unsignedBigInteger('personas_id')->nullable()->after('password');
            
            // 2. Create foreign key constraints
            $table->foreign('personas_id')->references('id')->on('personas')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('users', function (Blueprint $table) {
            
                // 1. Drop foreign key constraints
                $table->dropForeign(['personas_id']);
    
                // 2. Drop the column
                $table->dropColumn('personas_id');
            });
        
    }
};
