<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    public function dossier(){
        return $this->belongsTo(Dossieretudiant::class, "dossieretudiant_id");
    }

    public function anneacademique(){
        return $this->belongsTo(Anneeacademique::class, "anneeacademique_id");
    }

    public function choice(){
        return $this->hasMany(Choice::class);
    }

    public function frais(){
        return $this->hasMany(Frai::class);
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function notes(){
        return $this->hasMany(Note::class);
    }

    public function disciplineetudiant(){
        return $this->hasMany(Disciplineetudiant::class);
    }

    public function verssement(){
        return $this->hasMany(Verssement::class);
    }
}
