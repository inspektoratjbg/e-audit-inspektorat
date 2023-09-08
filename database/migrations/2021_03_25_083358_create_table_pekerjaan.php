<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePekerjaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran');
            $table->integer('ppk_id');
            $table->string('ppk_nama');
            $table->integer('konsultan_id');
            $table->string('konsultan_nama');
            $table->string('nama_penyedia');
            $table->string('nama_kegiatan');
            $table->string('nama_pekerjaan');
            $table->string('pagu_anggaran');
            $table->string('harga_perkiraan');
            $table->string('no_sk');
            $table->string('tanggal_sk');
            $table->string('nilai_kontrak');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->string('no_sk_addedum')->nullable();
            $table->string('tanggal_sk_addedum')->nullable();
            $table->string('nilai_kontrak_addedum')->nullable();
            $table->date('tanggal_mulai_addedum')->nullable();
            $table->date('tanggal_selesai_addedum')->nullable();
            $table->integer('status')->default('1');
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
        Schema::dropIfExists('pekerjaan');
    }
}
