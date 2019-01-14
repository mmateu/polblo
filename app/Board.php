<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    
    public function cards()
    {
        return $this->hasMany('App\Card');
    }
    
}
