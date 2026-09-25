<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }

    public function inscription(){
        return $this->belongsTo(Inscription::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
