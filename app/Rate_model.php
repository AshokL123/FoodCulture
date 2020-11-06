<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate_model extends Model
{
    protected $table = 'tbl_rate';

    protected $primaryKey = 'rate_id';
    
    protected $guarded = [];
}
