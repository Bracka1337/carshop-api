<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        // Backfill every row, soft-deleted ones too: the unique index covers them.
        $taken = [];
        DB::table('products')->orderBy('id')->select(['id', 'title'])->each(function (object $product) use (&$taken) {
            $base = Str::slug(str_replace('.', '-', $product->title)) ?: 'wheel';
            $slug = $base;

            for ($n = 2; isset($taken[$slug]); $n++) {
                $slug = "{$base}-{$n}";
            }

            $taken[$slug] = true;
            DB::table('products')->where('id', $product->id)->update(['slug' => $slug]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
