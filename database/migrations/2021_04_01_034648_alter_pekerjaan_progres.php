<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPekerjaanProgres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('pekerjaan_progres', function (Blueprint $table) {
            // $table->integer('verifikasi_by')->nullable();
            // $table->dateTime('verifikasi_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('pekerjaan_progres', function (Blueprint $table) {
            // $table->dropColumn('verifikasi_by');
            // $table->dropColumn('verifikasi_at');
        });
    }
}
