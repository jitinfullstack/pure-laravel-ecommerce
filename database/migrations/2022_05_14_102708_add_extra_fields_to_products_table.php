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
        Schema::table('products', function (Blueprint $table) {
            $table->string('lead_time')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_type')->nullable();
            $table->integer('is_promo');
            $table->integer('is_featured');
            $table->integer('is_discounted');
            $table->integer('is_trending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('lead_time');
            $table->dropColumn('tax');
            $table->dropColumn('tax_type');
            $table->dropColumn('is_promo');
            $table->dropColumn('is_featured');
            $table->dropColumn('is_discounted');
            $table->dropColumn('is_trending');
        });
    }
};
