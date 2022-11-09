<?php

use App\Models\Platform;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('aggregated_metrics', function (Blueprint $table) {
            $table->foreignIdFor(Platform::class)->after('value')->nullable()->constrained();
        });
    }

    public function down()
    {
        Schema::table('aggregated_metrics', function (Blueprint $table) {
            $table->dropColumn('platform_id');
        });
    }
};
