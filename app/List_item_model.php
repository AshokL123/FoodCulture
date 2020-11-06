<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class List_item_model extends Model
{
    protected $table = 'tbl_shopping_list_item';

    protected $primaryKey = 'item_id';
    
    protected $guarded = [];
}
