<?php

use App\PeringatanPekerjaan;
use App\Progres;
use App\Rencana;
use Illuminate\Support\Facades\DB;
use App\User;
use Carbon\Carbon;
// use App\TarifPengiriman;
use Spatie\Permission\Models\Role;
// use App\Pegawai;



function Roles()
{
  $iduser = auth()->user()->id;
  $user = User::find($iduser);
  $can = $user->roles->pluck('id')->toArray();
  return $can;
}

function userCan($permission)
{

  $iduser = auth()->user()->id;
  $user = User::find($iduser);
  $can = $user->can($permission);
  return $can;
  // return true;
}


function userRole($role)
{
  $iduser = auth()->user()->id;
  $user = User::find($iduser);
  $can = $user->hasAnyRole($role);
  return $can;
}

// $user->hasAnyRole('writer', 'reader');
function waktu($tanggal)
{
  $time = Carbon::parse($tanggal)->format('h:i:s');
  return $time;
}


function tgl_indo($tanggal, $cetak_hari = false)
{
  return Carbon::parse($tanggal)->isoFormat('D MMMM Y');
}



if (!function_exists('getkode')) {
  function getkode()
  {
    $panjang = 55;
    $karakter       = 'kodingin.com4543534-039849kldsam][].';
    $panjangKata = strlen($karakter);
    $kode = '';
    for ($i = 0; $i < $panjang; $i++) {
      $kode .= $karakter[rand(0, $panjangKata - 1)];
    }
    return $kode;
  }
}


function rangeMinggu($start, $end)
{
  $format = 'Y-m-d';
  $array = array();
  $interval = new DateInterval('P1D');
  $realEnd = new DateTime($end);
  $realEnd->add($interval);
  $vstart = new DateTime($start);
  $period = new DatePeriod($vstart, $interval, $realEnd);

  foreach ($period as $date) {
    $array[] = $date->format($format);
  }
  // return $array;

  $minggu = [];
  $rk = [];
  foreach ($array as $rd) {
    $adate = new DateTime($rd);
    $rk[] = $adate;
    $minggu[] = array(
      'week' => $adate->format("W"),
      'tahun' => $adate->format("Y"),
      'tanggal' => getStartAndEndDate($adate->format("W"), $adate->format("Y"))
    );
  }
  return array_map("unserialize", array_unique(array_map("serialize", $minggu)));
}

function getStartAndEndDate($week, $year)
{
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['awal'] = $dto->format('d-m-Y');
  $dto->modify('+6 days');
  $ret['akhir'] = $dto->format('d-m-Y');
  return $ret;
}

function getEndWeek($date)
{
  $adate = new DateTime($date);
  $dto = new DateTime();
  $dto->setISODate($adate->format("Y"), $adate->format("W"));
  $dto->modify('+6 days');
  $ret = $dto->format('Y-m-d');
  return $ret;
}


function colorpersen($persen)
{

  if ($persen <= 25) {
    $res = "bg-danger";
  } else if ($persen > 25 && $persen <= 50) {
    $res = "bg-warning";
  } else if ($persen > 50 && $persen <= 75) {
    $res = "bg-info";
  } else {
    $res = "bg-success";
  }
  return $res;
}


function itemRencana($id, $minggu, $return = null)
{

  $rencana = Rencana::where('pekerjaan_id', $id)->where('minggu_ke', $minggu)->first();

  if ($rencana) {
    $res = $rencana;
    if ($return == 'tanggal_awal') {
      $res = Carbon::parse($rencana->tanggal_awal)->format('d-m-Y');
    }

    if ($return == 'tanggal_selesai') {
      $res = Carbon::parse($rencana->tanggal_selesai)->format('d-m-Y');
    }

    if ($return == 'target') {
      $res = $rencana->target;
    }
  } else {
    $res = null;
  }
  return $res;
}


function progres($id, $minggu)
{
  $real = Progres::wherenull('deleted_at')->where('pekerjaan_id', $id)->where('minggu_ke', $minggu)->first();
  return $real;
}

function terkini($id)
{
  $real = Progres::select(DB::raw("max(realisasi) hasil,max(verifikasi_at)  tanggal"))->wherenotnull('verifikasi_at')->wherenull('deleted_at')->where('pekerjaan_id', $id)->first();
  return $real;
}

function kritis($id, $minggu)
{
  return  PeringatanPekerjaan::where('pekerjaan_id', $id)->where('minggu_ke', $minggu)->first();
}

function Realisasiterkini($pekerjaan)
{
}
