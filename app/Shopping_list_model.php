<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopping_list_model extends Model
{
    protected $table = 'tbl_shopping_list';

    protected $primaryKey = 'shopping_list_id';
    
    protected $guarded = [];
}
