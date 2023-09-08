<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PeringatanPekerjaan extends Model
{
    //
    use LogsActivity;
    protected static $logUnguarded = true;
    protected $table = "pekerjaan_peringatan";
    protected $guarded = [];
    protected $primaryKey = 'id';
}
