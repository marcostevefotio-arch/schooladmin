<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignantmatiere extends Model
{
    use HasFactory;

    protected $table = "enseignant_matieres";

    public function enseignant(){
        return $this->belongsTo(Enseignant::class);
    }

    public function matiere(){
        return $this->belongsTo(Matiere::class);
    }
}
