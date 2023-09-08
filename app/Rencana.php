<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Rencana extends Model
{
    use LogsActivity;
    protected static $logUnguarded = true;

    protected $table = "pekerjaan_rencana";
    protected $guarded = [];
    protected $primaryKey = 'id';
}
