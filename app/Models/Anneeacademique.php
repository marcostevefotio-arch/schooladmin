<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anneeacademique extends Model
{
    use HasFactory;


    public function dossier(){
        return $this->hasMany(Dossieretudiant::class);
    }

    public function inscriptions(){
        return $this->hasMany(Inscription::class);
    }

    public function scolarite(){
        return $this->hasMany(Scolarite::class);
    }
}
