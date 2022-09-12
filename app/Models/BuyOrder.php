<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyOrder extends Model
{
    use HasFactory;
    public $table='buyorder';
    protected $guarded=[];
    public $timestamps=false;

    public function Contact(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function Company(){
        return $this->belongsTo(Company::class, 'company_id','company_id');
    }
}
