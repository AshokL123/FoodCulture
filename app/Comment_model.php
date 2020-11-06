<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment_model extends Model
{
    protected $table = 'tbl_comment';

    protected $primaryKey = 'comment_id';
    
    protected $guarded = [];
}
