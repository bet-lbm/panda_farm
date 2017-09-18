<?php

namespace Panda;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'purchase_details';
  	
    protected $fillable = ['purchase_id','medicine_id','medicine_name','quantity','price','subtotal'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
