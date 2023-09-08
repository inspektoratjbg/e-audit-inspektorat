<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Konsultan extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;
    
    protected $table = "konsultan";
    protected $guarded = [];
    protected $primaryKey = 'id';
}
