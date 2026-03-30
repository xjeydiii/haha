<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('sku')->unique()->after('name');
            $table->text('description')->nullable()->after('sku');
            $table->integer('quantity')->default(0)->after('description');
            $table->decimal('price', 10, 2)->after('quantity');
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->after('price');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade')->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name', 'sku', 'description', 'quantity', 'price', 'category_id', 'supplier_id']);
        });
    }
};