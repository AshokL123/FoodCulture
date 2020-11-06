<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'tbl_subscription';

    protected $primaryKey = 'subscription_id';
    
    protected $guarded = [];
}
