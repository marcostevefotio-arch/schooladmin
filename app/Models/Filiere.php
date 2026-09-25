<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    public function specialites(){
        return $this->hasMany(Specialite::class);
    }
    
    protected static function booted () {
        static::deleting(function(Filiere $filiere) { // before delete() method call this
             $filiere->specialites()->delete();
             // do the rest of the cleanup...
        });
    }
}
