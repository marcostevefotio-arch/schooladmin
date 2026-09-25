<?php

namespace App\Http\Controllers;

use App\Models\Anneeacademique;
use App\Models\Compte;
use App\Models\Filiere;
use App\Models\Menu;
use App\Models\Scolarite;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDFS;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ScolariteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion de la scolarité";
        $this->titles = "Scolarité";
        $menu = Menu::where("code_menu", "=", "homescolarite")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("scolarite"));
        View::share('active', "homescolarite");
    }




    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $scolarite = Scolarite::all();

        return  view("scolarite.list")->with("data", $scolarite);
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

        $this->titles = "Scolarité";
        View::share('title', $this->titles);
        View::share('option_route', route("scolarite"));

        $compte = Compte::all();
        $annee = Anneeacademique::all();
        $filiere = Filiere::all();


        return  view("scolarite.form")
            ->with("compte", $compte)
            ->with("annee", $annee)
            ->with("filiere", $filiere);
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
            "compte"=>"required",
            "specialite"=>"required",
            "annee"=>"required",
            "montantScolarite"=>"required|min:0",
        ]);

        $scolarite = new Scolarite();
        $scolarite->codeScolarite = Str::random(20);
        $scolarite->compte_id = $request->input("compte");
        $scolarite->specialite_id = $request->input("specialite");
        $scolarite->anneeacademique_id = $request->input("annee");
        $scolarite->montantScolarite = $request->input("montantScolarite");
        $scolarite->descriptionScolarite = $request->input("description");
        $scolarite->save();

        Session::flash('message', 'Configuration de la scolarité enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');

        return redirect()->route("scolarite");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function show($scolarite)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function edit($scolarite)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $scolarite = Scolarite::where("id", "=", $scolarite)->first();

        $compte = Compte::all();
        $annee = Anneeacademique::all();
        $filiere = Filiere::all();


        return  view("scolarite.form")
            ->with("compte", $compte)
            ->with("annee", $annee)
            ->with("filiere", $filiere)
            ->with("data", $scolarite);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scolarite)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $request->validate([
            "compte"=>"required",
            "specialite"=>"required",
            "annee"=>"required",
            "montantScolarite"=>"required|min:1",
        ]);

        $scolarite = Scolarite::where("id", "=", $scolarite)->first();
        $scolarite->compte_id = $request->input("compte");
        $scolarite->specialite_id = $request->input("specialite");
        $scolarite->anneeacademique_id = $request->input("annee");
        $scolarite->montantScolarite = $request->input("montantScolarite");
        $scolarite->descriptionScolarite = $request->input("description");
        $scolarite->update();

        Session::flash('message', 'Configuration de la scolarité modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');

        return redirect()->route("scolarite");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function destroy($scolarite)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $scolarite = Scolarite::where("id", "=", $scolarite)->first();
        $scolarite->delete();

        Session::flash('message', 'Configuration de la scolarité Supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->route("scolarite");
    }




    public function ficheScolarite(){
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->titles = "Fiche de scolarité";
        View::share('title', $this->titles);
        View::share('option_route', route("scolarite"));

        $compte = Compte::all();
        $annee = Anneeacademique::all();
        $filiere = Filiere::all();


        return  view("scolarite.print")
            ->with("compte", $compte)
            ->with("annee", $annee)
            ->with("filiere", $filiere);
    }

    public function printFicheScolarite(Request $request){
        $request->validate([
            "specialite"=>"required",
            "annee"=>"required",
        ]);

        $annee = $request->input("annee");
        $sp = $request->input("specialite");

        if($sp!="all"){
            if(isset($annee)){
                $scolarite = Scolarite::where("specialite_id" , "=", $sp)->where("anneeacademique_id", "=", $annee)->orderBy("montantScolarite")->get();
                $specialite = Specialite::where("id" , "=", $sp)->get();
            }else{
                $scolarite = Scolarite::where("specialite_id" , "=", $sp)->orderBy("montantScolarite")->get();
                $specialite = Specialite::where("id", "=", $sp)->get();
            }
        }else{
            if(isset($annee)){
                $scolarite = Scolarite::where("anneeacademique_id", "=", $annee)->orderBy("montantScolarite")->get();
                $specialite = Specialite::all();
            }else{
                $scolarite = Scolarite::where("specialite_id" , "=", $sp)->orderBy("montantScolarite")->get();
                $specialite = Specialite::all();
            }
        }

        $annee = Anneeacademique::where("id", "=", $annee)->first();


        $data = array(
            "annee" => $annee,
            "specialite" => $specialite,
            "scolarite" => $scolarite
        );

        $pdf = PDFS::loadView('pdf.ficheScolarite',  $data);
        $pdf->setPaper('a4');
        $pdf->output();

        $this->saveLog("Impression des Fiches de scolarité", array("annee"=>json_encode($annee), "specialite"=>json_encode($specialite)), array(),array(), true,"NOTES");
        return $pdf->stream();
    }


    public function listAjax(Request $request){
        $scolariteID = $request->input("scolarite");

        $scolarite = Scolarite::where("id", "=", $scolariteID)->first();

        return response()->json($scolarite);
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="scolarite-configuration" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
