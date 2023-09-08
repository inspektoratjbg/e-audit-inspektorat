<?php

use App\Konsultan;
use App\Pejabat;
use App\Peringatan;
use App\Ppk;
use App\Unit;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DataPendukungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // user sys admin  
        user::create(['name' => 'Kang Admin', 'email' => 'admin@admin.com', 'password' => bcrypt('sipil')]);
        // permissions
        Permission::create(['name' => 'addedum.create']);
        Permission::create(['name' => 'konsultan.create']);
        Permission::create(['name' => 'konsultan.delete']);
        Permission::create(['name' => 'konsultan.edit']);
        Permission::create(['name' => 'konsultan.list']);
        Permission::create(['name' => 'pejabat.edit']);
        Permission::create(['name' => 'pejabat.list']);
        Permission::create(['name' => 'pekerjaan.create']);
        Permission::create(['name' => 'pekerjaan.delete']);
        Permission::create(['name' => 'pekerjaan.edit']);
        Permission::create(['name' => 'pekerjaan.list']);
        Permission::create(['name' => 'permissions.create']);
        Permission::create(['name' => 'permissions.delete']);
        Permission::create(['name' => 'permissions.edit']);
        Permission::create(['name' => 'permissions.list']);
        Permission::create(['name' => 'ppk.create']);
        Permission::create(['name' => 'ppk.delete']);
        Permission::create(['name' => 'ppk.edit']);
        Permission::create(['name' => 'ppk.list']);
        Permission::create(['name' => 'progres.create']);
        Permission::create(['name' => 'progres.verifikasi']);
        Permission::create(['name' => 'role.create']);
        Permission::create(['name' => 'role.delete']);
        Permission::create(['name' => 'role.edit']);
        Permission::create(['name' => 'role.list']);
        Permission::create(['name' => 'user.list']);
        Permission::create(['name' => 'user.role']);

        Permission::create(['name' => 'sppd.create']);
        Permission::create(['name' => 'sppd.delete']);
        Permission::create(['name' => 'sppd.edit']);
        Permission::create(['name' => 'sppd.list']);

        Permission::create(['name' => 'bast.create']);
        Permission::create(['name' => 'bast.delete']);
        Permission::create(['name' => 'bast.edit']);
        Permission::create(['name' => 'bast.list']);

        


        Role::create(['name' => 'Administrator'])->givePermissionTo(['user.list', 'user.role', 'role.list', 'role.create', 'role.edit', 'role.delete', 'permissions.list', 'permissions.create', 'permissions.edit', 'permissions.delete', 'ppk.list', 'ppk.create', 'ppk.edit', 'ppk.delete', 'konsultan.list', 'pekerjaan.list', 'pejabat.list', 'pejabat.edit', 'bast.list', 'sppd.list']);

        $user = User::find(1);
        $user->assignRole('Administrator');

        Role::create(['name' => 'Konsultan'])->givePermissionTo(['pekerjaan.list', 'progres.create']);

        Role::create(['name' => 'PPK'])->givePermissionTo(['konsultan.list', 'konsultan.create', 'konsultan.edit', 'konsultan.delete', 'pekerjaan.list', 'pekerjaan.create', 'pekerjaan.edit', 'pekerjaan.delete', 'progres.create', 'progres.verifikasi', 'sppd.create', 'sppd.delete', 'sppd.edit', 'sppd.list', 'bast.create', 'bast.delete', 'bast.edit', 'bast.list']);


        // tambahan
        Permission::create(["name" => "rencana.list"]);
        Permission::create(["name" => "rencana.edit"]);
        Permission::create(["name" => "rencana.create"]);
        $per = ['rencana.list', 'rencana.edit','rencana.create'];

        $rolea = Role::where('name', 'PPK')->first();
        $rolea->givePermissionTo($per);
        $roleb = Role::where('name', 'Konsultan')->first();
        $roleb->givePermissionTo($per);

        Unit::create(['kode_unit' => '1.1.1', 'nama_unit' => 'Dinas Pendidikan Dan Kebudayaan']);
        Unit::create(['kode_unit' => '1.2.1', 'nama_unit' => 'Dinas Kesehatan']);
        Unit::create(['kode_unit' => '1.2.2', 'nama_unit' => 'RSUD Jombang']);
        Unit::create(['kode_unit' => '1.2.3', 'nama_unit' => 'RSUD Ploso']);
        Unit::create(['kode_unit' => '1.3.1', 'nama_unit' => 'Dinas Pekerjaan Umum dan Penataan Ruang']);
        Unit::create(['kode_unit' => '1.4.1', 'nama_unit' => 'Dinas Perumahan dan Permukiman']);
        Unit::create(['kode_unit' => '1.5.1', 'nama_unit' => 'Satuan Polisi Pamong Praja']);
        Unit::create(['kode_unit' => '1.5.2', 'nama_unit' => 'Badan Penanggulangan Bencana Daerah']);
        Unit::create(['kode_unit' => '1.5.3', 'nama_unit' => 'Badan Kesatuan Bangsa dan Politik']);
        Unit::create(['kode_unit' => '1.6.1', 'nama_unit' => 'Dinas Sosial']);
        Unit::create(['kode_unit' => '2.1.1', 'nama_unit' => 'Dinas Tenaga Kerja']);
        Unit::create(['kode_unit' => '2.10.1', 'nama_unit' => 'Dinas Komunikasi dan Informatika']);
        Unit::create(['kode_unit' => '2.11.1', 'nama_unit' => 'Dinas Koperasi dan Usaha Mikro']);
        Unit::create(['kode_unit' => '2.12.1', 'nama_unit' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu (PTSP)']);
        Unit::create(['kode_unit' => '2.13.1', 'nama_unit' => 'Dinas Kepemudaan ']);
        Unit::create(['kode_unit' => '2.18.1', 'nama_unit' => 'Dinas Perpustakaan dan Kearsipan']);
        Unit::create(['kode_unit' => '2.2.1', 'nama_unit' => 'Dinas Pengendalian Penduduk']);
        Unit::create(['kode_unit' => '2.3.1', 'nama_unit' => 'Dinas Ketahanan Pangan dan Perikanan']);
        Unit::create(['kode_unit' => '2.5.1', 'nama_unit' => 'Dinas Lingkungan Hidup']);
        Unit::create(['kode_unit' => '2.6.1', 'nama_unit' => 'Dinas Kependudukan dan Pencatatan Sipil']);
        Unit::create(['kode_unit' => '2.7.1', 'nama_unit' => 'Dinas Pemberdayaan Masyarakat dan Desa']);
        Unit::create(['kode_unit' => '2.9.1', 'nama_unit' => 'Dinas Perhubungan']);
        Unit::create(['kode_unit' => '3.3.1', 'nama_unit' => 'Dinas Pertanian']);
        Unit::create(['kode_unit' => '3.3.2', 'nama_unit' => 'Dinas Peternakan']);
        Unit::create(['kode_unit' => '3.6.1', 'nama_unit' => 'Dinas Perdagangan dan Perindustrian']);
        Unit::create(['kode_unit' => '4.1.1', 'nama_unit' => 'Dewan Perwakilan Rakyat Daerah']);
        Unit::create(['kode_unit' => '4.1.10', 'nama_unit' => 'Kecamatan Bareng']);
        Unit::create(['kode_unit' => '4.1.11', 'nama_unit' => 'Kecamatan Diwek']);
        Unit::create(['kode_unit' => '4.1.12', 'nama_unit' => 'Kecamatan Gudo']);
        Unit::create(['kode_unit' => '4.1.13', 'nama_unit' => 'Kecamatan Jogoroto']);
        Unit::create(['kode_unit' => '4.1.14', 'nama_unit' => 'Kecamatan Jombang']);
        Unit::create(['kode_unit' => '4.1.15', 'nama_unit' => 'Kecamatan Kabuh']);
        Unit::create(['kode_unit' => '4.1.16', 'nama_unit' => 'Kecamatan Kesamben']);
        Unit::create(['kode_unit' => '4.1.17', 'nama_unit' => 'Kecamatan Kudu']);
        Unit::create(['kode_unit' => '4.1.18', 'nama_unit' => 'Kecamatan Megaluh']);
        Unit::create(['kode_unit' => '4.1.19', 'nama_unit' => 'Kecamatan Mojoagung']);
        Unit::create(['kode_unit' => '4.1.2', 'nama_unit' => 'Kepala Daerah dan Wakil Kepala Daerah']);
        Unit::create(['kode_unit' => '4.1.20', 'nama_unit' => 'Kecamatan Mojowarno']);
        Unit::create(['kode_unit' => '4.1.21', 'nama_unit' => 'Kecamatan Ngoro']);
        Unit::create(['kode_unit' => '4.1.22', 'nama_unit' => 'Kecamatan Ngusikan']);
        Unit::create(['kode_unit' => '4.1.23', 'nama_unit' => 'Kecamatan Perak']);
        Unit::create(['kode_unit' => '4.1.24', 'nama_unit' => 'Kecamatan Peterongan']);
        Unit::create(['kode_unit' => '4.1.25', 'nama_unit' => 'Kecamatan Plandaan']);
        Unit::create(['kode_unit' => '4.1.26', 'nama_unit' => 'Kecamatan Ploso']);
        Unit::create(['kode_unit' => '4.1.27', 'nama_unit' => 'Kecamatan Sumobito']);
        Unit::create(['kode_unit' => '4.1.28', 'nama_unit' => 'Kecamatan Tembelang']);
        Unit::create(['kode_unit' => '4.1.29', 'nama_unit' => 'Kecamatan Wonosalam']);
        Unit::create(['kode_unit' => '4.1.3', 'nama_unit' => 'Sekretariat Dewan']);
        Unit::create(['kode_unit' => '4.1.4', 'nama_unit' => 'Sekretariat Daerah']);
        Unit::create(['kode_unit' => '4.1.9', 'nama_unit' => 'Kecamatan Bandarkedungmulyo']);
        Unit::create(['kode_unit' => '4.2.1', 'nama_unit' => 'Inspektorat']);
        Unit::create(['kode_unit' => '4.3.1', 'nama_unit' => 'Badan Perencanaan Pembangunan Daerah']);
        Unit::create(['kode_unit' => '4.4.7', 'nama_unit' => 'Badan Pendapatan Daerah']);
        Unit::create(['kode_unit' => '4.4.8', 'nama_unit' => 'Badan Pengelolaan Keuangan dan Aset Daerah']);
        Unit::create(['kode_unit' => '4.5.6', 'nama_unit' => 'Badan Kepegawaian Daerah']);

        $faker = Faker::create('id_ID');

        $unit = Unit::get();

        foreach ($unit as $ik => $ru) {
            $ur = ($ik++) + 1 . "/FEB/PPK/21";
            $data = [
                'no_sk' => $ur,
                'tanggal_sk' => Carbon::now(),
                'nama' => $faker->name,
                'no_hp' => $faker->PhoneNumber, 'email' => $faker->safeEmail, 'kode_unit' => $ru->kode_unit, 'nama_unit' => $ru->nama_unit, 'created_by' => '1', 'created_at' => Carbon::now()
            ];
            $ppk = Ppk::create($data);
            User::create(['ppk_id' => $ppk->id, 'email' => $ppk->email, 'name' => $ppk->nama, 'password' => \bcrypt('sipil')])->assignRole('PPK');
        }

        $user = User::wherenotnull('ppk_id')->get();
        foreach ($user as $ru) {
            for ($i = 0; $i < 2; $i++) {
                $data = ['nama_konsultan' => $faker->name, 'no_hp' => $faker->PhoneNumber, 'email' => $faker->safeEmail, 'created_by' => $ru->id];
                $konsultan = Konsultan::create($data);
                User::create(['konsultan_id' => $konsultan->id, 'email' => $konsultan->email, 'name' => $konsultan->nama_konsultan, 'password' => \bcrypt('sipil')])->assignRole('Konsultan');
            }
        }


        // Pejabat
        Pejabat::create(['nama_pejabat' => 'Pejabat Irban Pembangunan', 'jabatan' => 'IRBAN PEMBANGUNAN', 'email' => 'pembangunan@inspektorat.com', 'created_by' => 1]);
        Pejabat::create(['nama_pejabat' => 'Pejabat PA', 'jabatan' => 'PA', 'email' => 'pejabatPA@inspektorat.com', 'created_by' => 1]);
        Pejabat::create(['nama_pejabat' => 'Sekda Kab Jombang', 'jabatan' => 'SEKDA', 'email' => 'sekda@jombankab.go.id', 'created_by' => 1]);


        // master peringatan
        Peringatan::create(['nama_peringatan' => 'KONTRAK PRA KRITIS :0 - 70 %', 'minimal' => '5', 'maksimal' => '10', 'deviasi' => '5', 'jenis' => '1']);
        Peringatan::create(['nama_peringatan' => 'KONTRAK KRITIS I :0 - 70 %', 'minimal' => '10', 'maksimal' => '100', 'deviasi' => '10', 'jenis' => '1']);
        Peringatan::create(['nama_peringatan' => 'KONTRAK PRA KRITIS :70,1 - 100 %', 'minimal' => '3', 'maksimal' => '5', 'deviasi' => '3', 'jenis' => '2']);
        Peringatan::create(['nama_peringatan' => 'KONTRAK KRITIS II :70,1 - 100 %', 'minimal' => '5', 'maksimal' => '100', 'deviasi' => '5', 'jenis' => '2']);
    }
}
