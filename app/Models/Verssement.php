<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verssement extends Model
{
    use HasFactory;


    public function scolarite(){
        return $this->belongsTo(Scolarite::class);
    }

    public function inscription(){
        return $this->belongsTo(Inscription::class, "inscription_id");
    }
}
