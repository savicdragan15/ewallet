<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLonToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('latitude')->nullable()->after('amount');
            $table->string('longitude')->nullable()->after('latitude');
            $table->string('flag')->nullable()->after('longitude');
            $table->text('location')->nullable()->after('flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'flag',
                'location',
            ]);
        });
    }
}
