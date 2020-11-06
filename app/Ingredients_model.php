<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients_model extends Model
{
    protected $table = 'tbl_ingredients';

    protected $primaryKey = 'ingredients_id';
    
    protected $guarded = [];
}
