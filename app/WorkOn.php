<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOn extends Model
{
    
    protected $fillable = ['idMandate','idUser'];
    protected $table = 'workon';
}
