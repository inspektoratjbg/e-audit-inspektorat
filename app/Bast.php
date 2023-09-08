<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Bast extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;

    protected $table = "pekerjaan_bast";
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function pekerjaan()
    {
        return $this->hasOne('App\Pekerjaan', 'id', 'pekerjaan_id');
    }
}
