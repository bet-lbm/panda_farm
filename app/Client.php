<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table='clients';
    protected $fillable=['dni','name','last_name','address','phone'];
}
