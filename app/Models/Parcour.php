<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcour extends Model
{
    use HasFactory;

    public function inscription(){
        return $this->hasMany(Inscription::class);
    }

    public function dossier(){
        return $this->belongsTo(Dossieretudiant::class, "dossieretudiant_id");
    }
}
