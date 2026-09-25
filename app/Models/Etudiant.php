<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;


    public function parents(){
        return $this->belongsTo(Perent::class, "parent_id");
    }

    public function dossier(){
        return $this->hasMany(Dossieretudiant::class, "etudiant_id");
    }

    public function antecedants(){
        return $this->hasMany(Antecedant::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    public function groupe(){
        return $this->belongsTo(Groupe::class);
    }

    public function demandes(){
        return $this->hasMany(Demande::class);
    }
}
