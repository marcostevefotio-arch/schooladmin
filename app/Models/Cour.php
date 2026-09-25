<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cour extends Model
{
    use HasFactory;

    protected $table = "cours";

    public function matiere(){
        return $this->belongsTo(Matiere::class);
    }

    public function enseignant(){
        return $this->belongsTo(Enseignant::class);
    }
}
