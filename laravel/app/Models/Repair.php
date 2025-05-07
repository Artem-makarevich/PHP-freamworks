<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'car_id',
        'description',
        'cost',
        'repair_date',
    ];


    public function users()
    {
        return $this->belongsTo(Users::class);
    }


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
