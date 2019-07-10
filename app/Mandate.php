<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mandate extends Model
{
    protected $table = 'mandate';

    protected $fillable = ['id','name', 'start','end','comment'];
}
