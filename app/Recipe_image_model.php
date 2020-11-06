<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe_image_model extends Model
{
    protected $table = 'tbl_recipe_image';

    protected $primaryKey = 'recipe_image_id';
    
    protected $guarded = [];
}
