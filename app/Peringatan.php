<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Peringatan extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;
    protected $table = "peringatan";
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
