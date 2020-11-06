<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_notes_model extends Model
{
    protected $table = 'tbl_user_notes';

    protected $primaryKey = 'note_id';
    
    protected $guarded = [];
}
