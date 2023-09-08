<?php

use App\Peringatan;
use Illuminate\Database\Seeder;

class MasterPeringatan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Peringatan::create(['nama_peringatan' => 'KONTRAK PRA KRITIS :0 - 70 %', 'minimal' => 0, 'maksimal' => 70, 'deviasi' => 5]);
        Peringatan::create(['nama_peringatan' => 'KONTRAK KRITIS 1 :0 - 70 %', 'minimal' => 0, 'maksimal' => 70, 'deviasi' => 10]);
        Peringatan::create(['nama_peringatan' => 'KONTRAK KRITIS 2 :0 - 70 %', 'minimal' => 0, 'maksimal' => 70, 'deviasi' => 10]);

        Peringatan::create(['nama_peringatan' => 'KONTRAK PRA KRITIS :70,1 - 100 %', 'minimal' => 70.1, 'maksimal' => 100, 'deviasi' => 3]);
        Peringatan::create(['nama_peringatan' => 'KONTRAK KRITIS 1 :70,1 - 100 %', 'minimal' => 70.1, 'maksimal' => 100, 'deviasi' => 5]);
        Peringatan::create(['nama_peringatan' => 'KONTRAK KRITIS 2 :70,1 - 100 %', 'minimal' => 70.1, 'maksimal' => 100, 'deviasi' => 5]);
    }
}
