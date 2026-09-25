<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public function semestre(){
        return $this->belongsTo(Semestre::class);
    }


    public function matiere(){
        return $this->belongsTo(Matiere::class);
    }

    public function inscription(){
        return $this->belongsTo(Inscription::class, "inscription_id");
    }
}
