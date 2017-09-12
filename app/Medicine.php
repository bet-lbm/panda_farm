<?php

namespace Panda;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Panda\Presentation;

class Medicine extends Model
{
    protected $table = 'medicines';
  	
    protected $fillable = ['batch','name','description','presentation_id','presentation_name','type','component','concentration','stock','purchase_price','sale_price','igv','production_date','expiration_date'];

    public function presentation()
    {
        return $this->belongsTo(Presentation::class);
    }

    

}
