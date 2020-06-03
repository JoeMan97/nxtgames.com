<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neww extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];
}
