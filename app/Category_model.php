<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_model extends Model
{
    protected $table = 'tbl_category';

    protected $primaryKey = 'category_id';
    
    protected $guarded = [];
}
