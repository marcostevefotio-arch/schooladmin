<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scolarite extends Model
{
    use HasFactory;

    public function compte(){
        return $this->belongsTo(Compte::class);
    }

    public function specialite(){
        return $this->belongsTo(Specialite::class);
    }

    public function anneeacademique(){
        return $this->belongsTo(Anneeacademique::class);
    }

    public function verssement(){
        return $this->hasMany(Verssement::class);
    }
}
