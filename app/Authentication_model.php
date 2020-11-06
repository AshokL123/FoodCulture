<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authentication_model extends Model
{
    protected $table = 'tbl_authentication';

    protected $primaryKey = 'auth_id';
    
    protected $guarded = [];
}
