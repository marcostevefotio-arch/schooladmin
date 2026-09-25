<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossieretudiant extends Model
{
    use HasFactory;

    public function anneeacademique(){
        return $this->belongsTo(Anneeacademique::class);
    }

    public function parcours(){
        return $this->hasMany(Parcour::class);
    }

    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }

    public function cycle(){
        return $this->belongsTo(Cycle::class);
    }

    public function inscriptions(){
        return $this->hasMany(Inscription::class);
    }
}
