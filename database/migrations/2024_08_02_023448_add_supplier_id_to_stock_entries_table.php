<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stock_entries', function (Blueprint $table) {
        $table->unsignedBigInteger('supplier_id')->nullable()->after('category_id');
        $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('stock_entries', function (Blueprint $table) {
        $table->dropForeign(['supplier_id']);
        $table->dropColumn('supplier_id');
    });
}

};
