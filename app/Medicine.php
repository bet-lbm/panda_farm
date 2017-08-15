<?php

namespace Panda;

use Illuminate\Database\Eloquent\Model;
use Panda\Presentation;

class Medicine extends Model
{
    protected $table = 'medicines';
    protected $fillable = ['batch','type','name','component','concentration','expiration_date','production_date','description','stock','purchanse_price','sale_price','igv'];
    
    public function presentation()
    {
        return $this->belongsTo(Presentation::class);
    }
}
