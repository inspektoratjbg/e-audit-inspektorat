<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePekerjaanRencanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerjaan_rencana', function (Blueprint $table) {
            $table->id();
            $table->integer('pekerjaan_id');
            $table->integer('minggu_ke');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('target');
            $table->integer('jenis')->nullable();
            $table->integer('verifikasi_by')->nullable();
            $table->dateTime('verifikasi_at')->nullable();
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
        Schema::dropIfExists('pekerjaan_rencana');
    }
}
