<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('aggregated_metrics', function (Blueprint $table) {
            $table->integer('total')->after('value');
        });
    }

    public function down()
    {
        Schema::table('aggregated_metrics', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
};
