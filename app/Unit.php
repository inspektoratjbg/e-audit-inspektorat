<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    protected $table = "ref_unit";
    protected $guarded = [];
    protected $primaryKey = 'kode_unit';
    public $incrementing = false;
    public $timestamps = false;
}
