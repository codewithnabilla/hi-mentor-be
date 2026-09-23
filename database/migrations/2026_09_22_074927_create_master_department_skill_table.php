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
        Schema::create('master.department_skill', function (Blueprint $table) {
            $table->id();

            $table->uuid('department_uuid');
            $table->uuid('skill_uuid');

            $table->foreign('department_uuid')
                ->references('uuid')
                ->on('master.departments')
                ->cascadeOnDelete();

            $table->foreign('skill_uuid')
                ->references('uuid')
                ->on('master.skills')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['department_uuid', 'skill_uuid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master.department_skill');
    }
};
