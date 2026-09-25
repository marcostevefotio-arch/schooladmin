<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Souscription extends Model
{
    use HasFactory;

    public function service(){
        return $this->belongsToMany(Service::class);
    }

    public function espace(){
        return $this->belongsToMany(Espace::class);
    }

    public function caisse(){
        return $this->belongsTo(Caisse::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
