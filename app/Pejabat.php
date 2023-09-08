<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Pejabat extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;
    
    protected $table = "pejabat";
    protected $guarded = [];
}
