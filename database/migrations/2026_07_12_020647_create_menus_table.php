<?php

use App\Traits\SchemaPrefixHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use SchemaPrefixHelper;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table('public', 'menus'), function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name');
            $table->string('route')->unique();
            $table->string('icon')->nullable();

            $table->uuid('parent_uuid')->nullable();

            $table->integer('order')->default(0);
            $table->string('permission')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::table($this->table('public', 'menus'), function (Blueprint $table) {
            $table->foreign('parent_uuid')
                ->references('uuid')
                ->on($this->table('public', 'menus'))
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table('public', 'menus'));
    }
};
