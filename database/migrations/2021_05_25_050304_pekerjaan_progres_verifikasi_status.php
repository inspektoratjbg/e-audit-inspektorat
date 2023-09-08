<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PekerjaanProgresVerifikasiStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pekerjaan_progres', function (Blueprint $table) {
            $table->integer('verifikasi_status')->nullable();
            $table->text('verifikasi_keterangan')->nullable();
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
            $table->dropColumn('verifikasi_status');
            $table->dropColumn('verifikasi_keterangan');
        });
    }
}
