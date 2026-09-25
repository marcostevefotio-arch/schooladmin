<?php

namespace App\Http\Controllers;

use App\Models\GroupePermission;
use App\Models\Historique;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request as RQ;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveLog($operation="", $defore=array(), $after=array(), $data=array(), $ended=true, $table=""){
        $log = new Historique();
        $log->codeHistorique = Str::random(20);
        $log->Before = json_encode($defore);
        $log->After = json_encode($after);
        $log->Data = json_encode($data);
        $log->ended = true;
        $log->ipadresse = RQ::ip();
        $log->tablename = $table;

        $utilisateur = User::find(auth()->user()->id);

        switch ($operation){
            case 1:
                $log->operation = "Consultation";
                $utilisateur->historique()->save($log);
                break;
            case 2:
                $log->operation = "Création";
                $utilisateur->historique()->save($log);
                break;
            case 3:
                $log->operation = "Lecture";
                $utilisateur->historique()->save($log);
                break;
            case 4:
                $log->operation = "Mise à jour";
                $utilisateur->historique()->save($log);
                break;
            case 5:
                $log->operation = "Suppression";
                $utilisateur->historique()->save($log);
                break;
            default:
                $log->operation = $operation;
                $utilisateur->historique()->save($log);
                break;
        }
    }
}
