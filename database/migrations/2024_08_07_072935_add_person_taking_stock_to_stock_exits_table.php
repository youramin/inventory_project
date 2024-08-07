<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('stock_exits', function (Blueprint $table) {
        $table->string('person_taking_stock')->after('notes');
    });
}

public function down()
{
    Schema::table('stock_exits', function (Blueprint $table) {
        $table->dropColumn('person_taking_stock');
    });
}

};
