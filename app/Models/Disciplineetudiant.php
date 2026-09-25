<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplineetudiant extends Model
{
    use HasFactory;

    public function inscription(){
        return $this->belongsTo(Inscription::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
