<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function enseignantMatiere(){
        return $this->hasMany(Enseignantmatiere::class);
    }

    public function disponibilites(){
        return $this->hasMany(Disponibilite::class);
    }

    public function discipline(){
        return $this->hasMany(Disciplineenseignant::class);
    }
}
