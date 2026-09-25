<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;

    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }

    public function classes(){
        return $this->hasMany(Classe::class);
    }

    public function choice(){
        return $this->hasMany(Choice::class);
    }

    public function ues(){
        return $this->hasMany(Ue::class);
    }

    public function scolarite(){
        return $this->hasMany(Scolarite::class);
    }
    
    protected static function booted () {
        static::deleting(function(Specialite $specialite) { // before delete() method call this
             $specialite->ues()->delete();
             $specialite->scolarite()->delete();
             // do the rest of the cleanup...
        });
    }
}
