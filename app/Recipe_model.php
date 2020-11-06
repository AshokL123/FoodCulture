<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe_model extends Model
{
    protected $table = 'tbl_recipe';

    protected $primaryKey = 'recipe_id';
    
    protected $guarded = [];
}
