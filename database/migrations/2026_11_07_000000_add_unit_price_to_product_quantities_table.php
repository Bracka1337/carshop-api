<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Store the price paid on each order line, so order totals no longer
     * follow later product price changes. Existing lines are backfilled
     * from the current product price (the best information available).
     */
    public function up(): void
    {
        Schema::table('product_quantities', function (Blueprint $table) {
            $table->decimal('unit_price', 10, 2)->nullable()->after('quantity');
        });

        DB::table('product_quantities')->update([
            'unit_price' => DB::raw('(SELECT products.price FROM products WHERE products.id = product_quantities.product_id)'),
        ]);

        Schema::table('product_quantities', function (Blueprint $table) {
            $table->decimal('unit_price', 10, 2)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('product_quantities', function (Blueprint $table) {
            $table->dropColumn('unit_price');
        });
    }
};
