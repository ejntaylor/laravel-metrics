<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->integer('value');
            $table->integer('total');
//            if(filled(config('metrics.parent'))) {
//                $table->foreignIdFor(config('metrics.parent'), 'parent_id')->nullable()->constrained();
//            }
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metrics');
    }
};
