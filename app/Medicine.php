<?php

namespace Panda;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Panda\Presentation;

class Medicine extends Model
{
    protected $table = 'medicines';
  	
    protected $fillable = ['batch','name','description','type','component','concentration','expiration_date','production_date','stock','purchanse_price','sale_price','igv'];

    public function presentation()
    {
        return $this->belongsTo(Presentation::class);
    }

    

}
