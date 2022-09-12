<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matching extends Model
{
    use HasFactory;
    public $table='matching';
    protected $guarded=[];
    public $timestamps=[];

    public function SaleOrder(){
        return $this->belongsTo(SellOrder::class,'sell_id','sell_id');
    }
    public function BuyOrder(){
        return $this->belongsTo(BuyOrder::class,'buy_id','buy_id');
    }
}
