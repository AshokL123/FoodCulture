<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite_model extends Model
{
    protected $table = 'tbl_favorite';

    protected $primaryKey = 'favorite_id';
    
    protected $guarded = [];
}
