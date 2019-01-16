<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{   
    
    public function isThereCardWithSameNamePresentInBoard() : bool
    {
        
        return (\App\Card::all()->where('name',$this->name)->
                      where('board_id', $this->board_id )->first()) !=  null;
    }
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
