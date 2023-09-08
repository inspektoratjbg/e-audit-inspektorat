<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Sppd extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;

    protected $table = "pekerjaan_sp2d";
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function pekerjaan()
    {
        return $this->hasOne('App\Pekerjaan', 'id', 'pekerjaan_id');
    }
}
