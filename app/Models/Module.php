<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function enfants(){
        return $this->hasMany(Module::class);
    }

    public function parent(){
        return $this->belongsTo(Module::class, "module_id");
    }

    public function permissions(){
        return $this->hasMany(Permission::class);
    }
}
