<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventilation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['idUser','ventilation'];

    public function setVentilationAttribute($value)
    {
        $this->attributes['ventilation'] = json_encode($value);
    }

    public function getVentilationAttribute($value)
    {
        return $this->attributes['ventilation'] = json_decode($value);
    }
}
