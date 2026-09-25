<?php

namespace App\Http\Controllers;

use App\Models\Anneeacademique;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AnneeacademiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des inscriptions";
        $this->titles = "Annees académique";
        $menu = Menu::where("code_menu", "=", "homeinscription")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("inscriptions-annee"));
        View::share('active', "homeinscription");
    }


    public function index()
    {
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $annee = Anneeacademique::orderBy("numeroAnnee")->get();
        return view("anneeacademique.list")->with("annee", $annee);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $annee = Anneeacademique::all();
        $maxannee = Anneeacademique::max("numeroAnnee");
        if(empty($maxannee)){
            $maxannee = date("Y");
        }

        $allAvalable = array();

        foreach (range($maxannee, $maxannee+50) as $a){
            $avalable = Anneeacademique::where("numeroAnnee", "=", $a)->first();
            if(empty($avalable)){
                array_push($allAvalable, $a);
            }
        }

        return view("anneeacademique.form")->with("annee", $annee)->with("maxannee", $maxannee)->with("avalable", $allAvalable);
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


        $request->validate([
            "numeroAnnee"=>"required|string|max:5|unique:anneeacademiques",
        ]);

        $allAnnee = Anneeacademique::all();

        foreach ($allAnnee as $a){
            $a->active = false;
            $a->update();
        }

        $annee = new Anneeacademique();
        $annee->codeAnnee = Str::random(20);
        $annee->numeroAnnee = $request->input("numeroAnnee");
        $annee->active = true;
        $annee->save();


        $this->saveLog(2, json_encode("$annee"), array(),array(), true,"ANNEE ACADEMIQUE");
        Session::flash('message', 'Année academique enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("inscriptions-annee");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anneeacademique  $anneeacademique
     * @return \Illuminate\Http\Response
     */
    public function show(Anneeacademique $anneeacademique)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anneeacademique  $anneeacademique
     * @return \Illuminate\Http\Response
     */
    public function edit(Anneeacademique $anneeacademique)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anneeacademique  $anneeacademique
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anneeacademique $anneeacademique)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anneeacademique  $anneeacademique
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anneeacademique $anneeacademique)
    {
        //
    }


    public function cloturer($year){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $annee = Anneeacademique::where("numeroAnnee","=", $year)->first();
        $allAnnee = Anneeacademique::all();

        foreach ($allAnnee as $a){
            $a->active = false;
            $a->update();
        }

        if($annee->active){
            $annee->active = false;
            $annee->update();

            Session::flash('message', 'Année cloturé avec succès');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succes');
        }else{
            $annee->active = true;
            $annee->update();

            Session::flash('message', 'Année démarré avec succès');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succes');
        }


        $this->saveLog(2, $annee, array(),array(), true,"ANNEE ACADEMIQUE");
        return redirect()->route("inscriptions-annee");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="inscriptions-annee" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
