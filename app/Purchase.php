<?php

namespace Panda;

use Illuminate\Database\Eloquent\Model;
use Panda\Dealer;
use Panda\Laboratory;
use Panda\PurchaseDetail;

class Purchase extends Model
{
    protected $table = 'purchases';
  	
    protected $fillable = ['code','dealer_id','laboratory_id','date','total_price'];

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }
    public function purchasedetail()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
