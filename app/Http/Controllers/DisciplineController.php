<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Disciplineenseignant;
use App\Models\Disciplineetudiant;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DisciplineController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des étudiants";
        $this->titles = "Effectifs des étudiants";
        $menu = Menu::where("code_menu", "=", "homeetudiant")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("etudiant"));
        View::share('active', "homeetudiant");
    }

    public function index(){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        return view("discipline.home");
    }

//    etudiants
    public function etudiant(){
        $specialite = Specialite::all();

        $data  = DB::table("specialites")
            ->selectRaw("etudiants.id, specialites.id as spid, sum(absences) as absences")
            ->join("choices", 'choices.specialite_id','=','specialites.id')
            ->join("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->join("etudiants", 'etudiants.id','=','inscriptions.etudiant_id')
            ->join("disciplineetudiants", 'etudiants.id','=','disciplineetudiants.etudiant_id')
            ->where("choices.etat",1)
            ->groupBy('spid','disciplineetudiants.etudiant_id')
            ->having('absences', '>',0)
            ->get();
        return view("discipline.students")->with("specialite", $specialite)->with("absences", $data);
    }

    public function discipline_et_create(){
        $filiere = Filiere::all();
        return view("discipline.studentsdisciplineform")->with("filiere", $filiere);
    }

    public function discipline_et_store (Request $request){

        $specialité = $request->input("specialite");
        $journee = $request->input("journee");

        $sp = Specialite::find($specialité);

        $data  = Specialite::select("etudiants.id", "libelleSpecialite")
            ->join("choices", 'choices.specialite_id','=','specialites.id')
            ->join("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->join("etudiants", 'etudiants.id','=','inscriptions.etudiant_id')
            ->where("specialites.id",$specialité)
            ->where("choices.etat",1)
            ->get();

        $count = 0;

        foreach ($data as $et){
            $absence = $request->input($et->id);
            if(isset($absence) && $absence>0){
                $discipline = new Disciplineetudiant();
                $discipline->codeDisciplineetudiants = Str::random(20);
                $discipline->user_id = auth()->user()->id;
                $discipline->etudiant_id = $et->id;
                $discipline->journee = $journee;
                $discipline->absences = $absence;

                $d = Disciplineetudiant::where("etudiant_id", "=", $et->id)->where("journee", "=", $journee)->first();

                if(empty($d)){
                    $discipline->save();
                    $count++;
                };
            }
        }

        Session::flash('message', 'Absence du '.date("d/m/Y", strtotime($journee)).' enregistré pour la spécialité '. $sp->libelleSpecialite);
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->back()->with("success");
    }

    public function discipline_et_show_specialite ($specialite){

        $sp = Specialite::find($specialite);

        $data_tmp  = DB::table("specialites")
            ->selectRaw("lastname, firstname, matricule, journee, absences")
            ->join("choices", 'choices.specialite_id','=','specialites.id')
            ->join("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->join("etudiants", 'etudiants.id','=','inscriptions.etudiant_id')
            ->join("disciplineetudiants", 'etudiants.id','=','disciplineetudiants.etudiant_id')
            ->where("choices.etat","=",1)
            ->where("specialites.id","=",$specialite)
            ->get();

        $data = collect($data_tmp)->groupBy("journee")->map(function ($item) {
            return array_merge($item->toArray());
        });

        return view("discipline.specialitesdisciplineRead")->with("specialite", $sp)->with("absences", $data);
    }



//    demandes
    public function demande(){
        $data = Demande::all();
        return view("discipline.demande")->with("demandes", $data);
    }

    public function demande_create(){
        $data = Filiere::all();
        return view("discipline.demande_form")->with("filiere", $data);
    }

    public function demande_show($slug){}

    public function demande_delete($slug){
        $demande = Demande::find($slug);
        $demande->delete();

        Session::flash('message', 'Demande de sortie supprimé ');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->back();
    }

    public function demande_store(Request $request){
        $demande = new Demande();
        $demande->user_id = auth()->user()->id;
        $demande->etudiant_id = $request->input("etudiants");
        $demande->codeDemande = Str::random(20);
        $demande->du = $request->input("du");
        $demande->au = $request->input("au");
        $demande->motifs = $request->input("motif");
        $demande->save();

        Session::flash('message', 'Demande de sortie enregistré du '.date("d/m/Y", strtotime($request->input("du"))).' au '. date("d/m/Y", strtotime($request->input("au"))));
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->back()->with("success");
    }

    public function demande_print($slug){

    }



    //    enseignants
    public function enseignant(){
        $discipen = Disciplineenseignant::all();
        return view("discipline.teacher")->with("discipline", $discipen);
    }

    public function discipline_en_create(){
        $enseignants = Enseignant::all();
        return view("discipline.teacherdisciplineform")->with("enseignants", $enseignants);
    }

    public function discipline_en_store (Request $request){

        $journee = $request->input("journee");
        $enseignant = $request->input("enseignant");
        $justifie = $request->input("justifie");

        $disciplineen = new Disciplineenseignant();
        $disciplineen->user_id = auth()->user()->id;
        $disciplineen->enseignant_id = $enseignant;
        $disciplineen->codeDisciplineenseignants =  Str::random(20);
        $disciplineen->journee = $journee;
        $disciplineen->absence = $request->input("absences");
        $disciplineen->motif = $request->input("motif");
        $disciplineen->justifie = isset($justifie)? true : false;

        $disen = Disciplineenseignant::where("journee", $journee)->where("enseignant_id", $enseignant)->first();
        if(empty($disen)){
            $disciplineen->save();
            Session::flash('message', 'Absence du '.date("d/m/Y", strtotime($journee)).' enregistré');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succes');
        }else{
            Session::flash('message', 'Une absence existant pour cet enseignant a la date du '.date("d/m/Y", strtotime($journee)));
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
        }


        return redirect()->back()->with("success");
    }

    public function discipline_en_show ($specialite){

        $sp = Specialite::find($specialite);

        $data_tmp  = DB::table("specialites")
            ->selectRaw("lastname, firstname, matricule, journee, absences")
            ->join("choices", 'choices.specialite_id','=','specialites.id')
            ->join("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->join("etudiants", 'etudiants.id','=','inscriptions.etudiant_id')
            ->join("disciplineetudiants", 'etudiants.id','=','disciplineetudiants.etudiant_id')
            ->where("choices.etat","=",1)
            ->where("specialites.id","=",$specialite)
            ->get();

        $data = collect($data_tmp)->groupBy("journee")->map(function ($item) {
            return array_merge($item->toArray());
        });

        return view("discipline.specialitesdisciplineRead")->with("specialite", $sp)->with("absences", $data);
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="etudiant-discipline" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }

}
