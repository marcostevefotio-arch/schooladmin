<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function module(){
        return $this->belongsTo(Module::class);
    }

    public function groupe(){
        return $this->belongsToMany(Groupe::class, "groupe_permission")->withTimestamps();
    }
}
