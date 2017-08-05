<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $table = 'dealers';
    protected $fillable = ['ruc','name','address','phone'];
}
