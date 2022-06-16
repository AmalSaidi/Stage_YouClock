<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fichehor extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function getTotalPriceAttribute() {
        return $this->heuresEffectu;
    }

}
