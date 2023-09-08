<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Pekerjaan extends Model
{
    //

    use LogsActivity;
    protected static $logUnguarded = true;

    protected $table = "pekerjaan";
    protected $guarded = [];
    protected $primaryKey = 'id';


   /*  public function progresTerkini()
    {
        
        return $this->hasOne('App\Progres', 'pekerjaan_id', 'id')->whereNotNull('verifikasi_at')->orderbyraw("minggu_ke ASC");
    }
 */
    public function ppk()
    {
        return $this->hasOne('App\Ppk', 'id', 'ppk_id');
    }

    public function UnitPpkAttribute()
    {
        return optional($this->ppk)->nama_unit;
    }

    public function rencana()
    {
        return $this->hasMany('App\Rencana', 'pekerjaan_id', 'id')->whereNull('deleted_at')->orderbyraw("minggu_ke ASC");
    }

    public function scopeTelat($sql)
    {
        return    $sql->leftjoin('pekerjaan_rencana', 'pekerjaan_rencana.pekerjaan_id', '=', 'pekerjaan.id')->leftjoin('pekerjaan_progres', function ($join) {
            $join->on('pekerjaan_progres.pekerjaan_id', '=', 'pekerjaan_rencana.id')
                ->on('pekerjaan_progres.minggu_ke', '=', 'pekerjaan_rencana.minggu_ke');
        })->whereraw("pekerjaan_rencana.deleted_at IS NULL  AND pekerjaan_progres.deleted_at IS NULL
        AND pekerjaan_progres.id IS  NULL
        AND pekerjaan.deleted_at IS NULL")->where('pekerjaan_rencana.tanggal_selesai', '<', Carbon::today()->toDateString());
        // return $sql;
    }

    public function scopeDeviasi($sql)
    {

        return    $sql->join('pekerjaan_rencana', 'pekerjaan_rencana.pekerjaan_id', '=', 'pekerjaan.id')->join('pekerjaan_peringatan', function ($join) {
            $join->on('pekerjaan_peringatan.pekerjaan_id', '=', 'pekerjaan_rencana.pekerjaan_id')
                ->on('pekerjaan_peringatan.minggu_ke', '=', 'pekerjaan_rencana.minggu_ke');
        })->whereraw("pekerjaan_rencana.deleted_at IS NULL");
    }

    public function dokumen()
    {
        return $this->hasMany('App\PekerjaanFile', 'pekerjaan_id', 'id')->whereNull('deleted_at');
    }

    public function sp2d()
    {
        return $this->hasMany('App\Sppd', 'pekerjaan_id', 'id')->whereNull('deleted_at');
    }
}
