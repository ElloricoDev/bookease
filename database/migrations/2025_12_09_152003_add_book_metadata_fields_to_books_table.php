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
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn')->unique()->nullable()->after('author');
            $table->string('category')->nullable()->after('isbn');
            $table->string('publisher')->nullable()->after('category');
            $table->integer('publication_year')->nullable()->after('publisher');
            $table->text('description')->nullable()->after('publication_year');
            $table->string('language')->default('English')->after('description');
            $table->enum('condition', ['new', 'good', 'fair', 'poor'])->default('good')->after('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'category', 'publisher', 'publication_year', 'description', 'language', 'condition']);
        });
    }
};
