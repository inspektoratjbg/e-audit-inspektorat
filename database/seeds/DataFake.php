<?php

use App\Konsultan;
use App\Ppk;
use App\Unit;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DataFake extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id_ID');
        // dd($faker->company);

        $user = User::wherenotnull('ppk_id')->get();
        foreach ($user as $ru) {
            $data=[
                'nama_konsultan'=> $faker->company,
                'no_hp'=>$faker->PhoneNumber,
                'email'=>$faker->email,
                'created_by'=>$ru->id
            ];
            $konsultan=Konsultan::create($data);
            User::create(
                [
                    'konsultan_id' => $konsultan->id,
                    'email' => $konsultan->email,
                    'name' => $konsultan->nama_konsultan,
                    'password' => \bcrypt('sipil')
                ]
            )->assignRole('Konsultan');

        }

        /* $unit = Unit::where('kode_unit', '<>', '1.2.2')->get();
        $data = [];
         foreach($unit as $ru){
            $data=[
                'nama'=>$faker->name,
                'no_hp'=>$faker->PhoneNumber,
                'email'=> $faker->email,
                'kode_unit'=>$ru->kode_unit,
                'nama_unit'=>$ru->nama_unit,
                'created_by'=>'1',
                'created_at'=>Carbon::now()
            ];
            $ppk=Ppk::create($data);
            User::create(
                [
                    'ppk_id' => $ppk->id,
                    'email' => $ppk->email,
                    'name' => $ppk->nama,
                    'password' => \bcrypt('sipil')
                ]
            )->assignRole('PPK');
        }
 */        // dd($data);

    }
}
