<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('aggregated_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->integer('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aggregated_metrics');
    }
};
