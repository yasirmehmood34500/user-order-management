<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public $table='company';
    public $guarded=[];
    public $timestamps=false;

    public function Location(){
        return $this->belongsTo(Location::class, 'geog_id','geog_id');
    }
    public function Business(){
        return $this->belongsTo(Business::class, 'business_id','business_id');
    }

    public function Sector(){
        return $this->belongsTo(Sector::class, 'sector_id','sector_id');
    }

    public function Sectors(){
        return $this->hasMany(CompanyHasSectors::class, 'company_id','company_id');
    }
}
