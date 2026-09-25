<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\Menu;
use App\Models\Specialite;
use App\Models\Ue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des enseignants";
        $this->titles = "Cours";
        $menu = Menu::where("code_menu", "=", "homeenseignant")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("enseignant-cours"));
        View::share('active', "homeenseignant");
    }


    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $enseignant = Enseignant::all();
        $cours = Cour::all();
        $this->saveLog(1, array(), array(),array(), true,"COURS");
        return view("cours.list")->with("cours",$cours)->with("enseignants",$enseignant);
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


        $data = Filiere::all();
        $ue = Ue::all();
        $enseignants = Enseignant::all();
        return view("cours.form")->with("filiere",$data)->with("ue",$ue)->with("enseignants",$enseignants);
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

        $validate = $request->validate([
            "specialite"=>"required",
            "matiere"=>"required",
            "enseignant"=>"required",
            "datecours"=>"required",
            "duree"=>"required",
        ]);


        if(!$validate){
            return redirect()->route("newCours", ["slug"=>$request->input("specialite")])->withInput($request->all())->withErrors($validate->errors());
        }else{
            $journee = $request->input("debut");
            $data = new Cour();
            $data->codeCours = Str::random(20);
            $data->specialite_id = $request->input("specialite");
            $data->enseignant_id = $request->input("enseignant");
            $data->matiere_id = $request->input("matiere");
            $data->debutCours = $request->input("datecours");
            $data->dureeCours = $request->input("duree");
            $data->termine = false;
            $data->save();

            $this->saveLog(2, array(), array(),$data, true,"COURS");
            Session::flash('message', 'Absence du '.date("d/m/Y", strtotime($journee)).' enregistré');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succes');
            return redirect()->route("programmeShow", ["slug"=>$request->input("specialite")])->with("success", "success");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cour  $cour
     * @return \Illuminate\Http\Response
     */
    public function show($programme)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $specialite = Specialite::where("id", "=", $programme)->first();
        $this->saveLog(3, $programme, array(),array(), true,"PLANNING");
        return view("planing.timetable")->with("specialite", $specialite);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cour  $cour
     * @return \Illuminate\Http\Response
     */
    public function edit($specialite, $cour)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data2 = Cour::where("id", "=", $cour)->first();
        $data = Specialite::where("id", "=", $data2->matiere->ues->specialite->id)->first();
        return view("planing.datesplan")->with("specialite",$data)->with("data",$data2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cour  $cour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cour)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $validate = $request->validate([
            "matiere"=>"required",
            "intituleCours"=>"required",
            "debut"=>"required",
            "duree"=>"required",
        ]);


        if(!$validate){
            return redirect()->route("newCours", ["slug"=>$request->input("specialite")])->withInput($request->all())->withErrors($validate->errors());
        }else{
            $data = Cour::where("id","=", $cour)->first();
            $data->matiere_id = $request->input("matiere");
            $data->intituleCours = $request->input("intituleCours");
            $data->debutCours = $request->input("debut");
            $data->dureeCours = $request->input("duree");
            $data->description = $request->input("description");
            $data->update();

            $this->saveLog(4, $cour, array(),$data, true,"COURS");

            return redirect()->route("programmeShow", ["slug"=>$request->input("specialite")])->with("success", "success");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cour  $cour
     * @return \Illuminate\Http\Response
     */
    public function destroy($cour)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $cours = Cour::where("id", "=", $cour)->first();
        $cours->delete();

        $this->saveLog(5, $cour, array(),$cours, true,"COURS");

        return redirect()->back();
    }


    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="planing-cours" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
