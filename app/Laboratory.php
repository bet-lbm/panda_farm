<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    protected $table='laboratories';
    protected $fillable=['name','health_code','authorization','phone'];
}
