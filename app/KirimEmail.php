<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class KirimEmail extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $table = "kirim_email";
    protected $guarded = [];
}
