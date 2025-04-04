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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('venue_name');
            $table->text('venue_description')->nullable();
            $table->text('venue_details')->nullable();
            $table->integer('venue_capacity');
            $table->unsignedBigInteger('venue_category_id');
            $table->decimal('guest_price', 8, 2);
            $table->decimal('member_price', 8, 2);
            $table->text('venue_notes')->nullable();
            $table->string('cover_photo')->nullable();
            $table->json('slider_images')->nullable();
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->timestamps();

        $table->foreign('venue_category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
