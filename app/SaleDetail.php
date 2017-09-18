<?php

namespace Panda;

use Illuminate\Database\Eloquent\Model;
use Panda\Medicine;
use Panda\Sale;

class SaleDetail extends Model
{
    protected $table = 'sale_details';
  	
    protected $fillable = ['sale_series','sale_number','medicine_id','medicine_name','quantity','sale_price','discount','subtotal'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
