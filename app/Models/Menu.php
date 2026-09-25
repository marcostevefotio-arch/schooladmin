<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function menu_parent(){
        return $this->belongsTo(Menu::class);
    }

    public function menu_enfants(){
        return $this->hasMany(Menu::class);
    }

    public function permission(){
        return $this->hasMany(Permission::class);
    }
}
