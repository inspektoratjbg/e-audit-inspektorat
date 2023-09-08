<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeringatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerjaan_peringatan', function (Blueprint $table) {
            $table->id();
            $table->integer('pekerjaan_id');
            $table->integer('minggu_ke');
            $table->decimal('rencana');
            $table->decimal('realisasi');
            $table->decimal('deviasi');
            $table->integer('peringatan_id');
            $table->string('peringatan_nama');
            $table->date('mail_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerjaan_peringatan');
    }
}

