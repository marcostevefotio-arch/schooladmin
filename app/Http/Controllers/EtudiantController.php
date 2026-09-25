<?php

namespace App\Http\Controllers;

use App\Models\Anneeacademique;
use App\Models\Cycle;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Menu;
use App\Models\Specialite;
use App\Models\Scolarite;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDFS;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
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


    public function index($filter="")
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $annee = Anneeacademique::where("active", "=", true)->first();
        $isFilter = false;
        if($filter=="") {
            $data = Etudiant::select("etudiants.*", "etudiants.id as idEt", "dossieretudiants.*", "specialites.*", "filieres.*", "inscriptions.*", "levels.*", "cycles.*")
                ->leftJoin("dossieretudiants", "etudiants.id", "=", "dossieretudiants.etudiant_id")
                ->leftJoin("inscriptions", "dossieretudiants.id", "=", "inscriptions.dossieretudiant_id")
                ->leftJoin("levels", "levels.id", "=", "inscriptions.level_id")
                ->leftJoin("cycles", "cycles.id", "=", "dossieretudiants.cycle_id")
                ->leftJoin("choices", "inscriptions.id", "=", "choices.inscription_id")
                ->leftJoin("specialites", "specialites.id", "=", "choices.specialite_id")
                ->leftJoin("filieres", "filieres.id", "=", "specialites.filiere_id")
                ->where("inscriptions.anneeacademique_id", "=", $annee->id)
                ->where("choices.etat", "=", 1)
                ->get();
        }else{
            $data = Etudiant::select("etudiants.*", "etudiants.id as idEt", "dossieretudiants.*", "specialites.*", "filieres.*", "inscriptions.*",  "levels.*", "cycles.*")
                ->leftJoin("dossieretudiants", "etudiants.id", "=", "dossieretudiants.etudiant_id")
                ->leftJoin("inscriptions", "dossieretudiants.id", "=", "inscriptions.dossieretudiant_id")
                ->leftJoin("levels", "levels.id", "=", "inscriptions.level_id")
                ->leftJoin("cycles", "cycles.id", "=", "dossieretudiants.cycle_id")
                ->leftJoin("choices", "inscriptions.id", "=", "choices.inscription_id")
                ->leftJoin("specialites", "specialites.id", "=", "choices.specialite_id")
                ->leftJoin("filieres", "filieres.id", "=", "specialites.filiere_id")
//                ->where("inscriptions.anneeacademique_id", "=", $annee->id)
                ->where("choices.etat", "=", 1)
                ->get();


            $isFilter = true;
        }

        return view("etudiants.list")->with("data", $data)->with("isfilter", $isFilter);
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


        Session::flash('message', 'Ue enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function show($etud)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $annee = Anneeacademique::where("active", "=", true)->first();
        $data = Etudiant::select("etudiants.*")
            ->where("etudiant_id", "=", $etud)
            ->leftJoin("dossieretudiants", "etudiants.id", "=", "dossieretudiants.etudiant_id")
            ->leftJoin("inscriptions", "dossieretudiants.id", "=", "inscriptions.dossieretudiant_id")
            ->leftJoin("levels", "levels.id", "=", "inscriptions.level_id")
            ->leftJoin("cycles", "cycles.id", "=", "dossieretudiants.cycle_id")
            ->leftJoin("choices", "inscriptions.id", "=", "choices.inscription_id")
            ->leftJoin("specialites", "specialites.id", "=", "choices.specialite_id")
            ->leftJoin("filieres", "filieres.id", "=", "specialites.filiere_id")
//            ->where("inscriptions.anneeacademique_id", "=", $annee->id)
            ->first();
        $this->titles = "Etudiant ".$data->firstname." ".$data->lastname;
        View::share('title', $this->titles);
        return view("etudiants.read")->with("data", $data)->with("offline", true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function edit(Etudiant $etudiant)
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
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Etudiant $etudiant)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
    }


    public function AjaxStudentList(Request $request){

        $specialite = $request->input("specialite");
        $anneeID = $request->input("annee");

        if(isset($anneeID)){
            $annee = Anneeacademique::where("id", "=", $anneeID)->first();
        }else{
            $annee = Anneeacademique::where("active", "=", true)->first();
        }


        $data  = Specialite::select("etudiants.id", "lastname", "firstname", "matriculeDossier", "inscriptions.id as inscrID")
            ->leftJoin("choices", 'choices.specialite_id','=','specialites.id')
            ->leftJoin("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->leftJoin("dossieretudiants", 'dossieretudiants.id','=','inscriptions.dossieretudiant_id')
            ->leftJoin("etudiants", 'etudiants.id','=','dossieretudiants.etudiant_id')
            ->where("specialites.id",$specialite)
            ->where("choices.etat",1)
            ->where("inscriptions.anneeacademique_id","=", $annee->id)
            ->orderBy("lastname")
            ->get()
            ->groupBy(["inscriptions.anneeacademique_id"]);



        return response()->json($data);
    }


    public function AjaxStudentList2(Request $request){

        $scolarite = $request->input("specialite");
        $anneeID = $request->input("annee");

        if(isset($anneeID)){
            $annee = Anneeacademique::where("id", "=", $anneeID)->first();
        }else{
            $annee = Anneeacademique::where("active", "=", true)->first();
        }
        
        
        $specialite = Scolarite::where("id", "=", $scolarite)->first();
        


        $data  = Specialite::select("etudiants.id", "lastname", "firstname", "matriculeDossier", "inscriptions.id as inscrID")
            ->leftJoin("choices", 'choices.specialite_id','=','specialites.id')
            ->leftJoin("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->leftJoin("dossieretudiants", 'dossieretudiants.id','=','inscriptions.dossieretudiant_id')
            ->leftJoin("etudiants", 'etudiants.id','=','dossieretudiants.etudiant_id')
            ->where("specialites.id",$specialite->specialite->id)
            ->where("choices.etat",1)
            ->where("inscriptions.anneeacademique_id","=", $annee->id)
            ->orderBy("firstname")
            ->get();



        return response()->json($data);
    }

    public function avatarChange(Request $request){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        Validator::make($request->all(),[
            "image" => "requred|mime:png,jpg,jpeg|max:2048",
            "etudiant" => "required"
        ]);

        $etudiantID = $request->input("etudiant");
        $etudiant = Etudiant::where("id", "=", $etudiantID)->first();
        $request->file("image")->move("assets/images/etudiants",$etudiant->dossier[0]->matriculeDossier.".png");

        $etudiant->avatar = "assets/images/etudiants/".$etudiant->dossier[0]->matriculeDossier.".png";
        $etudiant->avatarType = ".png";
        $etudiant->update();

        $this->saveLog("CHANGEMENT DE PHOTO", array(), array(),array(), true,"ETUDIANT");

        return redirect()->back();
    }


    public function imprimerCarte($id){
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Etudiant::where("id","=", $id)->first();

        $pdf = PDFS::loadView('pdf.carteetudiant',  compact('data'));
        $pdf->setPaper('A6','');
        $pdf->output();
        /*
        $canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();
        $canvas->set_opacity(.1,"Multiply");
        $canvas->page_text($width/2.5, $height/2, 'IFPSTAT', null,
            90, array(0,0,0),2,2,-30);
        */
        return $pdf->stream();
    }


    public function imprimerBibliotheque($id){

        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Etudiant::where("id","=", $id)->first();

//        return view('pdf.cartebibliotheque', compact('data'));
        set_time_limit(150);

        $pdf = PDFS::loadView('pdf.cartebibliotheque',  compact('data'));
        $pdf->setPaper('a6', 'landscape');
        $pdf->output();
        /**$canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();
        $canvas->set_opacity(.1,"Multiply");
        $canvas->page_text($width/2.5, $height/2, 'IFPSTAT', null,
            90, array(0,0,0),2,2,-30);
        */
        return $pdf->stream();
    }

    public function listOfStudent($sort){
        ini_set('max_execution_time', -1);
        ini_set("memory_limit","512M");
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data1 = Etudiant::all()->sortBy(["lastname", "firstname"]);
        $data2 = Filiere::all();

        $data4 = Etudiant::select("nationality")->distinct()->get();
        $data5 = Etudiant::select("language")->distinct()->get();
        $data6 = Etablissement::all()->first();
//        return view('pdf.listes')->with('data', $data)->with('data2', $data2)->with('data3', $data3)->with("by", $sort)->with('data4', $data4)->with('data5', $data5)->with('count', 1);
        $annee = Anneeacademique::where("active", "=", true)->first();
        $data = array(
            "data1"=>$data1,
            "data2"=>Filiere::all(),
            "data3"=> Cycle::all(),
            "data4"=>$data4,
            "data5"=>$data5,
            "by"=>$sort,
            "count"=>1,
            "annee"=>empty($annee)? -1 : $annee,
            "school"=> $data6
        );

        $pdf = PDFS::loadView('pdf.listes',  compact('data'));
        $pdf->setPaper('L');
        return $pdf->stream();
    }



    public function demission(){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $etudiant = Etudiant::all();

        return view("etudiants.demissions")->with("data", $etudiant);
    }


    public function notes($etudiant_id=""){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        if(!empty($etudiant_id)){
            $etudiant = Etudiant::find($etudiant_id);

            return view("etudiants.list")->with("data", $etudiant);
        }else{
            return redirect()->route('etudiant');
        }
    }

    public function releve($etudiant_id=""){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        if(!empty($etudiant_id)){
            $etudiant = Etudiant::find($etudiant_id);

            return view("etudiants.list")->with("data", $etudiant);
        }else{
            return redirect()->route('etudiant');
        }
    }

    public function carte(){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $data = Filiere::all();
        return view("etudiants.cartes")->with("data", $data);
    }

    public function cartePrint(Request $request){
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        
        
        $specialite = $request->input("specialite");
        $annee = Anneeacademique::where("active", "=", true)->first();


        $data  = Specialite::select("etudiants.*", "specialites.*",  "filieres.*",  "dossieretudiants.*", "inscriptions.id as inscrID")
            ->leftJoin("choices", 'choices.specialite_id','=','specialites.id')
            ->leftJoin("inscriptions", 'inscriptions.id','=','choices.inscription_id')
            ->leftJoin("dossieretudiants", 'dossieretudiants.id','=','inscriptions.dossieretudiant_id')
            ->leftJoin("etudiants", 'etudiants.id','=','dossieretudiants.etudiant_id')
            ->leftJoin("filieres", 'filieres.id','=','specialites.filiere_id')
            ->where("specialites.id",$specialite)
            ->where("choices.etat",1)
            ->where("inscriptions.anneeacademique_id","=", $annee->id)
            ->orderBy("lastname")
            ->get();
            
        $etudiants = array("collection"=>$data);
        
        //dd($etudiants);
        
        $pdf = PDFS::loadView('pdf.all-carteetudiant',  compact('etudiants'));
        $pdf->setPaper('A4','');
        $pdf->output();
        
        return $pdf->stream();
        
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="etudiant-effectifs" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
