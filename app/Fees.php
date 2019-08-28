<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    protected $primaryKey = 'idFees';

    protected $fillable = ['price', 'feesComment','idWorktime'];
}
