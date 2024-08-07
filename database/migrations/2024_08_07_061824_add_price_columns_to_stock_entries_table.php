<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stock_entries', function (Blueprint $table) {
        $table->decimal('unit_price', 10, 2)->nullable()->after('quantity');
        $table->decimal('total_price', 10, 2)->nullable()->after('unit_price');
    });
}

public function down()
{
    Schema::table('stock_entries', function (Blueprint $table) {
        $table->dropColumn(['unit_price', 'total_price']);
    });
}

};
