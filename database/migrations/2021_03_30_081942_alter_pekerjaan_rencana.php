<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPekerjaanRencana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('pekerjaan_rencana', function (Blueprint $table) {
            // $table->integer('jenis')->after('pekerjaan_id')->nullable();
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
        Schema::table('pekerjaan_rencana', function (Blueprint $table) {
            // $table->dropColumn('jenis');
        });
    }
}
