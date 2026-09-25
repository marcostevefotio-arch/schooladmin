<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function index(){
        return view("myspace.accueil");
    }

    public function discipline($user){
        return view("myspace.etudiants.madiscipline");
    }

    public function note($user){
        return view("myspace.etudiants.mesnotes");
    }

    public function evaluation($user){
        return view("myspace.etudiants.mesevaluations");
    }

    public function planing($user){
        return view("myspace.etudiants.monplaning");
    }


//    enseignants

    public function tplaning(){
        return view("myspace.enseignants.monplaning");
    }

    public function tevaluation(){
        return view("myspace.enseignants.mesevaluations");
    }
    public function makeEvaluation(){
        return view("myspace.enseignants.formevaluation");
    }

    public function storeEvaluation(Request $request){
        $validate = $request->validate([
            "specialite"=>"required",
            "matiere"=>"required",
            "classe"=>"required",
            "date_evaluation"=>"required",
            "duree_ecaluation"=>"required",
        ]);


        if(!$validate){
            return redirect()->back();
        }else {
//            $evaluation = new Evaluation();
//            $evaluation->personnel_id = ;
//            $evaluation->specialite_id  = ;
//            $evaluation->semestre_id  = ;
//            $evaluation->matiere_id  = ;
//            $evaluation->dateevaluation = ;
//            $evaluation->typeevaluation = ;
//            $evaluation->typeevaluation = ;
        }
    }
    public function epreuve(){
        return view("myspace.enseignants.formepreuve");
    }

    public function storeEpeuvre(Request $request){

    }

    public function runEvaluation(){
        return view("myspace.enseignants.monplaning");
    }
}
