<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_model extends Model
{
    protected $table = 'tbl_purchase';

    protected $primaryKey = 'user_purchase_id';
    
    protected $guarded = [];
}
