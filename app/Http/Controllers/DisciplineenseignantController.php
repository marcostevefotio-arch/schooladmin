<?php

namespace App\Http\Controllers;

use App\Models\Disciplineenseignant;
use App\Models\Enseignant;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class DisciplineenseignantController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des enseignants";
        $this->titles = "Discipline des enseignants";
        $menu = Menu::where("code_menu", "=", "homeenseignant")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("enseignant-discipline"));
        View::share('active', "homeenseignant");
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

        $discipen = Disciplineenseignant::all();
        $this->saveLog(1, array(), array(),array(), true,"DISCIPLINE ENSEIGNANT");
        return view("discipline.teacher")->with("discipline", $discipen);
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

        $enseignants = Enseignant::all();
        return view("discipline.teacherdisciplineform")->with("enseignants", $enseignants);
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


        $journee = $request->input("journee");
        $enseignant = $request->input("enseignant");
        $justifie = $request->input("justifie");

        $disciplineen = new Disciplineenseignant();
        $disciplineen->user_id = auth()->user()->id;
        $disciplineen->codeDisciplineenseignants = Str::random(20);
        $disciplineen->enseignant_id = $enseignant;
        $disciplineen->journee = $journee;
        $disciplineen->absence = $request->input("absences");
        $disciplineen->motif = $request->input("motif");
        $disciplineen->justifie = isset($justifie)? true : false;

        $disen = Disciplineenseignant::where("journee", $journee)->where("enseignant_id", $enseignant)->first();

        if(empty($disen)){
            $disciplineen->save();
            $this->saveLog(2, $disciplineen, array(),array(), true,"DISCIPLINE ENSEIGNANT");
            Session::flash('message', 'Absence du '.date("d/m/Y", strtotime($journee)).' enregistré avec succès');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succes');
        }else{
            Session::flash('message', 'Une absence existant pour cet enseignant a la date du '.date("d/m/Y", strtotime($journee)));
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disciplineenseignant  $disciplineenseignant
     * @return \Illuminate\Http\Response
     */
    public function show($disciplineenseignant)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(3, $disciplineenseignant, array(),array(), true,"DISCIPLINE ENSEIGNANT");

//        $sp = Specialite::find($specialite);
//
//        $data_tmp  = DB::table("specialites")
//            ->selectRaw("lastname, firstname, matricule, journee, absences")
//            ->join("choices", 'choices.specialite_id','=','specialites.id')
//            ->join("inscriptions", 'inscriptions.id','=','choices.inscription_id')
//            ->join("etudiants", 'etudiants.id','=','inscriptions.etudiant_id')
//            ->join("disciplineetudiants", 'etudiants.id','=','disciplineetudiants.etudiant_id')
//            ->where("choices.etat","=",1)
//            ->where("specialites.id","=",$specialite)
//            ->get();
//
//        $data = collect($data_tmp)->groupBy("journee")->map(function ($item) {
//            return array_merge($item->toArray());
//        });
//
//        return view("discipline.specialitesdisciplineRead")->with("specialite", $sp)->with("absences", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disciplineenseignant  $disciplineenseignant
     * @return \Illuminate\Http\Response
     */
    public function edit(Disciplineenseignant $disciplineenseignant)
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
     * @param  \App\Models\Disciplineenseignant  $disciplineenseignant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disciplineenseignant $disciplineenseignant)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->saveLog(4, $disciplineenseignant, array(),array(), true,"DISCIPLINE ENSEIGNANT");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disciplineenseignant  $disciplineenseignant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disciplineenseignant $disciplineenseignant)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->saveLog(5, $disciplineenseignant, array(),array(), true,"DISCIPLINE ENSEIGNANT");

    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="enseignant-discipline" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
