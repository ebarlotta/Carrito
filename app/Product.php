<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function scopeBuscar($query, $Filtro) {
        if($Filtro) {
            return $query->where('name', 'like', "%$Filtro%");
        }
    }
}
