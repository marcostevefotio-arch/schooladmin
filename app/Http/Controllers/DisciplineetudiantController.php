<?php

namespace App\Http\Controllers;

use App\Models\Anneeacademique;
use App\Models\Demande;
use App\Models\Disciplineetudiant;
use App\Models\Filiere;
use App\Models\Menu;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class DisciplineetudiantController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des étudiants";
        $this->titles = "Discipline des etudiants";
        $menu = Menu::where("code_menu", "=", "homeetudiant")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("disciplineetudiant"));
        View::share('active', "homeetudiant");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $specialite = Specialite::all();

        $data  = DB::table("specialites")
            ->selectRaw("etudiants.id, specialites.id as spid, sum(absences) as absences")
            ->join("choices", 'choices.specialite_id','=','specialites.id')
            ->join("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->join("dossieretudiants", 'dossieretudiants.id','=','inscriptions.dossieretudiant_id')
            ->join("etudiants", 'etudiants.id','=','dossieretudiants.etudiant_id')
            ->join("disciplineetudiants", 'inscriptions.id','=','disciplineetudiants.inscription_id')
            ->where("choices.etat",1)
            ->groupBy('spid','dossieretudiants.etudiant_id')
            ->having('absences', '>',0)
            ->get();
        return view("discipline.students")->with("specialite", $specialite)->with("absences", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $filiere = Filiere::all();
        $this->saveLog(1, array(), array(),array(), true,"DISCIPLINE ETUDIANT");
        return view("discipline.studentsdisciplineform")->with("filiere", $filiere);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $specialité = $request->input("specialite");
        $journee = $request->input("journee");

        $sp = Specialite::find($specialité);
        $annee = Anneeacademique::where("active", "=", true)->first();

        $data  = Specialite::select("etudiants.id", "libelleSpecialite", "inscriptions.id as inscrID")
            ->join("choices", 'choices.specialite_id','=','specialites.id')
            ->join("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->join("dossieretudiants", 'dossieretudiants.id','=','inscriptions.dossieretudiant_id')
            ->join("etudiants", 'etudiants.id','=','dossieretudiants.etudiant_id')
            ->where("specialites.id",$specialité)
            ->where("choices.etat",1)
            ->where("inscriptions.anneeacademique_id","=", $annee->id)
            ->get();

        $count = 0;

        foreach ($data as $et){
            $absence = $request->input($et->id);
            if(isset($absence) && $absence>0){
                $discipline = new Disciplineetudiant();
                $discipline->user_id = auth()->user()->id;
                $discipline->codeDisciplineetudiants = Str::random(20);
                $discipline->inscription_id = $et->inscrID;
                $discipline->journee = $journee;
                $discipline->absences = $absence;

                $d = Disciplineetudiant::where("inscription_id", "=", $et->inscrID)->where("journee", "=", $journee)->first();

                if(empty($d)){
                    $discipline->save();
                    $count++;
                };
            }
        }
        $this->saveLog(2, array(), array(),array(), true,"DISCIPLINE ETUDIANT");

        Session::flash('message', 'Absence du '.date("d/m/Y", strtotime($journee)).' enregistré pour la spécialité '. $sp->libelleSpecialite);
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->back()->with("success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disciplineetudiant  $disciplineetudiant
     * @return \Illuminate\Http\Response
     */
    public function show($specialite)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $sp = Specialite::find($specialite);
        $annee = Anneeacademique::where("active", "=", true)->first();

        $data_tmp  = DB::table("specialites")
            ->selectRaw("lastname, firstname, matriculeDossier, journee, absences")
            ->join("choices", 'choices.specialite_id','=','specialites.id')
            ->join("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->join("dossieretudiants", 'dossieretudiants.id','=','inscriptions.dossieretudiant_id')
            ->join("etudiants", 'etudiants.id','=','dossieretudiants.etudiant_id')
            ->join("disciplineetudiants", 'inscriptions.id','=','disciplineetudiants.inscription_id')
            ->where("choices.etat","=",1)
            ->where("choices.etat","=",1)
            ->where("specialites.id","=",$specialite)
            ->where("inscriptions.anneeacademique_id","=", $annee->id)
            ->get();

        $data = collect($data_tmp)->groupBy("journee")->map(function ($item) {
            return array_merge($item->toArray());
        });
        $this->saveLog(3, $specialite, array(),array(), true,"DISCIPLINE ETUDIANT");

        return view("discipline.specialitesdisciplineRead")->with("specialite", $sp)->with("absences", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disciplineetudiant  $disciplineetudiant
     * @return \Illuminate\Http\Response
     */
    public function edit(Disciplineetudiant $disciplineetudiant)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disciplineetudiant  $disciplineetudiant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disciplineetudiant $disciplineetudiant)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(4, $disciplineetudiant, array(),array(), true,"DISCIPLINE ETUDIANT");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disciplineetudiant  $disciplineetudiant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disciplineetudiant $disciplineetudiant)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(5, $disciplineetudiant, array(),array(), true,"DISCIPLINE ETUDIANT");
    }



    public function demande(){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $this->titles = "Demandes de sortie";
        View::share('title', $this->titles);
        View::share('option_route', route("demande"));

        $data = Demande::all();
        $this->saveLog(1, array(), array(),array(), true,"DISCIPLINE ETUDIANT");
        return view("discipline.demande")->with("demandes", $data);
    }

    public function demande_create(){
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Filiere::all();
        $this->titles = "Demandes de sortie";
        View::share('title', $this->titles);
        View::share('option_route', route("demande"));
        return view("discipline.demande_form")->with("filiere", $data);
    }

    public function demande_show($slug){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->saveLog(3, array(), array(),array(), true,"DISCIPLINE ETUDIANT");

    }

    public function demande_delete($slug){
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $demande = Demande::find($slug);
        $demande->delete();

        $this->saveLog(5, $demande, array(),array(), true,"DISCIPLINE ETUDIANT");
        Session::flash('message', 'Demande de sortie supprimé ');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->back();
    }

    public function demande_store(Request $request){
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $demande = new Demande();
        $demande->user_id = auth()->user()->id;
        $demande->inscription_id = $request->input("etudiants");
        $demande->codeDemande = Str::random(20);
        $demande->du = $request->input("du");
        $demande->au = $request->input("au");
        $demande->motifs = $request->input("motif");
        $demande->save();

        $this->saveLog(2, $demande, array(),array(), true,"DISCIPLINE ETUDIANT");
        Session::flash('message', 'Demande de sortie enregistré du '.date("d/m/Y", strtotime($request->input("du"))).' au '. date("d/m/Y", strtotime($request->input("au"))));
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->back()->with("success");
    }

    public function demande_print($slug){
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


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
