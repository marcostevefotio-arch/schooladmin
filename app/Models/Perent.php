<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perent extends Model
{
    use HasFactory;

    protected $table = "parents";

    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }
}
