<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHasSectors extends Model
{
    use HasFactory;
    protected $table='company_has_sectors';
    protected $guarded=[];

    public function Sector(){
        return $this->belongsTo(Sector::class, 'sector_id','sector_id');
    }
}
