<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePekerjaanBastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerjaan_bast', function (Blueprint $table) {
            $table->id();
            $table->integer('pekerjaan_id');
            $table->date('tgl_bast');
            $table->string('no_bast');
            $table->text('keterangan')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at');
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerjaan_bast');
    }
}
