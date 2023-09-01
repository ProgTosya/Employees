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
        Schema::create('employees', function (Blueprint $table) {
            $table->id()->unique();

            $table->string('name');
            $table->string('sur_name');
            $table->string('father_name');
            $table->string('rank');
            $table->smallInteger('pay')->unsigned();
            $table->date('work_to');
            $table->string('image')->nullable();

            $table->tinyInteger('rank_level')->unsigned();
            $table->integer('employee_id')->unsigned()->unique();
            $table->integer('boss_id')->unsigned();

            $table->longText('subordinates');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
