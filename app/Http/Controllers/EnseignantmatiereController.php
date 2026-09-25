<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Enseignantmatiere;
use App\Models\Menu;
use App\Models\Ue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class EnseignantmatiereController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des enseignants";
        $this->titles = "Repartition des UE";
        $menu = Menu::where("code_menu", "=", "homeenseignant")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("enseignant-matiere"));
        View::share('active', "homeenseignant");
    }



    public function index()
    {
        $enseignant = Enseignant::all();
        $this->saveLog(1, $enseignant, array(),array(), true,"MATIERE ENSEIGNANTS");
        return view("enseignants.enseignantsue")->with("enseignant", $enseignant);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $enseignant = Enseignant::all();
        $ue = Ue::all();
        return view("enseignants.enseignantsueform")->with("enseignants", $enseignant)->with("ue", $ue);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "matiere" => "required",
            "enseignant" => "required",
            "niveau" => "required|min:1"
        ]);



        $enseignantmatiere = new Enseignantmatiere();
        $enseignantmatiere->enseignant_id = $request->input("enseignant");
        $enseignantmatiere->codeEM = Str::random(20);
        $enseignantmatiere->matiere_id = $request->input("matiere");
        $enseignantmatiere->niveau = $request->input("niveau");
        $enseignantmatiere->etat = true;

        $enseignantmatiere->save();

        $this->saveLog(2, $enseignantmatiere, array(),array(), true,"MATIERE ENSEIGNANTS");
        Session::flash('message', 'Ue attribué avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->route("enseignant-matiere");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enseignantmatiere  $enseignantmatiere
     * @return \Illuminate\Http\Response
     */
    public function show(Enseignantmatiere $enseignantmatiere)
    {

        $this->saveLog(3, $enseignantmatiere, array(),array(), true,"MATIERE ENSEIGNANTS");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enseignantmatiere  $enseignantmatiere
     * @return \Illuminate\Http\Response
     */
    public function edit(Enseignantmatiere $enseignantmatiere)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enseignantmatiere  $enseignantmatiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enseignantmatiere $enseignantmatiere)
    {
        $this->saveLog(4, $enseignantmatiere, array(),array(), true,"MATIERE ENSEIGNANTS");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enseignantmatiere  $enseignantmatiere
     * @return \Illuminate\Http\Response
     */
    public function destroy($enseignantmatiere)
    {
        $enseignantmatiere = Enseignantmatiere::find($enseignantmatiere);
        $enseignant = $enseignantmatiere->enseignant_id;
        $enseignantmatiere->delete();

        $this->saveLog(5, $enseignantmatiere, array(),array(), true,"MATIERES ENSEIGNANTS");
        return redirect()->route("enseignantShow", ["slug"=>$enseignant])->with("success","Saved");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="enseignant-matiere" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
