<?php

namespace Panda;

use Illuminate\Database\Eloquent\Model;
use Panda\Client;
use Panda\SaleDetail;
use Panda\User;

class Sale extends Model
{
    protected $table = 'sales';
  	
    protected $fillable = ['series','number','type','client_id','user_id','date','subtotal','igv','total_price','enabled'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function saledetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
