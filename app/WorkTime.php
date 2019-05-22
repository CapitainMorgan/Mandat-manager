<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    protected $fillable = ['start', 'end','comment','idMandate','idUser', 'idPrice'];
}
