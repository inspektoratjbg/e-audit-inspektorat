<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Ppk extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;
    
    protected $table = "ppk";
    protected $guarded = [];
    protected $primaryKey = 'id';
}
