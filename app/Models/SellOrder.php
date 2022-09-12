<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellOrder extends Model
{
    use HasFactory;
    public $table='sellorder';
    protected $guarded=[];
    public $timestamps=false;

    public function Contact(){
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function Company(){
        return $this->belongsTo(Company::class, 'company_id','company_id');
    }
}
