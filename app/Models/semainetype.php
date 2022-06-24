<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semainetype extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['idUser','jour','DM','FM','DA','FA','DS','FS'];

}
