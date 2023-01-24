<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'car_model_id', 'service_id'];


    public function service()
    {
        return $this->hasOne(Services::class,'id','service_id');
    }
    public function car()
    {
        return $this->hasOne(Car::class,'id','car_model_id');
    }
}
