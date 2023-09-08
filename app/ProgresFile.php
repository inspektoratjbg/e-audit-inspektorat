<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ProgresFile extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;

    protected $table = "pekerjaan_progres_file";
    protected $guarded = [];
    protected $primaryKey = 'id';
}
