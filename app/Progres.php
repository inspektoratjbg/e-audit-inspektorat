<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Progres extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;

    protected $table = "pekerjaan_progres";
    protected $guarded = [];
    protected $primaryKey = 'id';


    public function dokumen()
    {
        return $this->hasMany('App\ProgresFile', 'pekerjaan_progres_id', 'id')->whereNull('deleted_at');
    }

    public function Pekerjaan()
    {
        return $this->hasOne('App\Pekerjaan', 'id', 'pekerjaan_id');
    }
}
