<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Matchings(){
        return $this->hasMany(matching::class,'pair_id','id');
    }
}
