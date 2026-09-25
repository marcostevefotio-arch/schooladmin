<?php

namespace App\Http\Controllers;

use App\Models\Anneeacademique;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Menu;
use App\Models\Scolarite;
use App\Models\Verssement;
use App\Models\Specialite;
use App\Models\Etablissement;
use Barryvdh\DomPDF\Facade as PDFS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class VerssementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion de la scolarité";
        $this->titles = "Versements";
        $menu = Menu::where("code_menu", "=", "homescolarite")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("verssement"));
        View::share('active', "homescolarite");
    }




    public function index($filter="")
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        


        if($filter!=="all" || $filter!==""){
            $verssement = Verssement::leftJoin("inscriptions", "inscriptions.id", "=", "verssements.inscription_id")
                ->leftJoin("anneeacademiques", "anneeacademiques.id", "=", "inscriptions.anneeacademique_id")
                ->where("anneeacademiques.id", "=", $filter)
                ->get();
        }else{
            $verssement = Verssement::leftJoin("inscriptions", "inscriptions.id", "=", "verssements.inscription_id")
                ->leftJoin("anneeacademiques", "anneeacademiques.id", "=", "inscriptions.anneeacademique_id")
                ->get();
        }

        $annee = Anneeacademique::all();

        return  view("verssement.list")
            ->with("data", $verssement)
            ->with("filtre", $filter)
            ->with("annee", $annee);
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

        $this->titles = "Verssements";
        View::share('title', $this->titles);
        View::share('option_route', route("verssement"));

        $scolarite = Scolarite::all();
        $filiere = Filiere::all();
        $inscription = Inscription::all();


        return  view("verssement.form")
            ->with("filiere", $filiere)
            ->with("scolarite", $scolarite)
            ->with("inscription", $inscription);
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
            "scolarite"=>"required",
            "etudiants"=>"required",
            "dateverssement"=>"required",
            "montant"=>"required|min:0",
        ]);

        $verssement = new Verssement();
        $verssement->codeVerssement = Str::random(20);
        $verssement->scolarite_id = $request->input("scolarite");
        $verssement->inscription_id = $request->input("etudiants");
        $verssement->montantVerssement = $request->input("montant");
        $verssement->dateVerssement = $request->input("dateverssement");
        $verssement->descriptionVerssement = $request->input("motif");

        $verssement->save();

        Session::flash('message', 'Verssement enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');

        return redirect()->route("verssement");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function show($verssement)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        
        
        $verssement = Verssement::where("codeVerssement", "=", $verssement)->first();
        return view("verssement.read")->with("data", $verssement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function edit($verssement)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $verssement = Verssement::where("codeVerssement", "=", $verssement)->first();

        $scolarite = Scolarite::all();
        $filiere = Filiere::all();
        $inscription = Inscription::all();


        return  view("verssement.form")
            ->with("scolarite", $scolarite)
            ->with("inscription", $inscription)
            ->with("filiere", $filiere)
            ->with("data", $verssement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $verssement)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $request->validate([
            "dateverssement"=>"required",
            "montant"=>"required|min:0",
        ]);

        $verssement = Verssement::where("codeVerssement", "=", $verssement)->first();
        $verssement->montantVerssement = $request->input("montant");
        $verssement->dateVerssement = $request->input("dateverssement");
        $verssement->descriptionVerssement = $request->input("motif");
        $verssement->update();

        Session::flash('message', 'Verssement modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');

        return redirect()->route("verssement");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function destroy($verssement)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $verssement = Verssement::where("codeVerssement", "=", $verssement)->first();
        $verssement->delete();

        Session::flash('message', 'Configuration de la scolarité Supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->route("verssement");
    }
    
    
    public function delete($verssement)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $verssement = Verssement::where("codeVerssement", "=", $verssement)->first();
        $verssement->delete();

        Session::flash('message', 'Configuration de la scolarité Supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->route("verssement");
    }

    

    public function printEtat(){
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->titles = "Etat des verssements";
        View::share('title', $this->titles);
        View::share('option_route', route("verssement"));

        $scolarite = Scolarite::all();
        $filiere = Filiere::all();
        $inscription = Inscription::all();
        $allAnnee = Anneeacademique::all();


        return  view("verssement.etatverssement")
            ->with("filiere", $filiere)
            ->with("scolarite", $scolarite)
            ->with("inscription", $inscription)
            ->with("annees", $allAnnee);
    }

    public function etatVerssements(Request $request){
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->titles = "Etat des verssements";
        View::share('title', $this->titles);
        View::share('option_route', route("verssement"));

        $etudiant = $request->input("etudiants");
        $specialite = $request->input("scolarite");
        $annee = Anneeacademique::where("active", "=", true)->first();
        if(!isset($etudiant)){
            $verssement = Verssement::orderBy("dateVerssement")
                ->leftjoin("inscriptions", "inscriptions.id", "=", "verssements.inscription_id")
                ->leftjoin("dossieretudiants", "dossieretudiants.id", "=", "inscriptions.dossieretudiant_id")
                ->leftjoin("etudiants", "etudiants.id", "=", "dossieretudiants.etudiant_id")
                ->get()->groupBy(["dateVerssement", "matriculeDossier"]);
        }else{
            $verssement = Verssement::orderBy("dateVerssement")
                ->leftjoin("inscriptions", "inscriptions.id", "=", "verssements.inscription_id")
                ->leftjoin("dossieretudiants", "dossieretudiants.id", "=", "inscriptions.dossieretudiant_id")
                ->leftjoin("etudiants", "etudiants.id", "=", "dossieretudiants.etudiant_id")
                ->where("etudiants.id", "=", $etudiant)
                ->get()->groupBy(["dateVerssement", "matriculeDossier"]);
        }

        if(count($verssement)<=0){
            Session::flash('message', 'Aucun verssement pour cet etudiant trouvé');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $scolarite = Scolarite::where("specialite_id", "=", $specialite)->get();

        $data = array(
            "annee" => $annee,
            "specialite" => $specialite,
            "scolarite" => $scolarite,
            "verssement" => $verssement,
        );

        $pdf = PDFS::loadView('pdf.etatverssement',  $data);
        $pdf->setPaper('a4');
        $pdf->output();

        $this->saveLog("Impression des etats de verssement", array("annee"=>json_encode($annee), "specialite"=>json_encode($specialite)), array(),array(), true,"NOTES");
        return $pdf->stream();
    }

    public function scolarite($specialite){
        $scolarite = Scolarite::where("specialite_id", "=", $specialite)->get();
        return response()->json("$scolarite");
    }

    public function solvabilite(){
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->titles = "Solvabilité";
        View::share('title', $this->titles);
        View::share('option_route', route("scolarite"));

        $annee = Anneeacademique::all();
        $filiere = Filiere::all();


        return  view("verssement.solvabilite")
            ->with("annee", $annee)
            ->with("filiere", $filiere);
    }

    public function solvabilitePrint(Request $request){
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->titles = "Fiche de solvabilité";
        View::share('title', $this->titles);
        View::share('option_route', route("scolarite"));

        $anneeID = $request->input("annee");
        $sp = $request->input('specialite');
        $specialite = Specialite::where("id", "=", $sp)->first();



        $total = Scolarite::where("anneeacademique_id", "=", $anneeID)->where("specialite_id", "=", $sp)->sum("montantScolarite");
        $annee = Anneeacademique::where("id", "=", $anneeID)->first();
        $inscription = Inscription::select("inscriptions.*")
            ->where("inscriptions.anneeacademique_id", "=", $annee->id)
            ->leftJoin("dossieretudiants", "dossieretudiants.id", "=", "inscriptions.dossieretudiant_id")
            ->leftJoin("etudiants", "etudiants.id", "=", "dossieretudiants.etudiant_id")
            ->leftJoin("choices", "choices.inscription_id", "=", "inscriptions.id")
            ->leftJoin("specialites", "choices.specialite_id", "=", "specialites.id")
            ->where("choices.etat", "=", 1)
            ->where("choices.specialite_id", "=", $sp)
            ->orderBy("firstname")
            ->orderBy("lastname")
            ->get();
        if(count($inscription)<=0){
            Session::flash('message', 'Aucun etudiant dans inscrit dans cette specialite');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $scolarite = Scolarite::where("anneeacademique_id", "=", $annee->id)->get();

        $data = array(
            "annee" => $annee,
            "inscription" => $inscription,
            "specialite" => $specialite,
            "scolarite" => $scolarite,
            "total" => $total,
            "school" => Etablissement::all()->first()
        );

        $pdf = PDFS::loadView('pdf.solvabilite',  $data);
        $pdf->setPaper('a4');
        $pdf->output();

        $this->saveLog("Impression des Fiches de scolarité", array(), array(),array(), true,"Scolarite");
        return $pdf->stream();
    }
    
    
    
    public function receipt($verssement){
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        
        
        $dataV = Verssement::where("codeVerssement", "=", $verssement)->first();
        

        $data = array(
            "verssement" => $dataV,
            "school" => Etablissement::all()->first()
        );

        $pdf = PDFS::loadView('pdf.receipt',  $data);
        $pdf->setPaper('a4');
        $pdf->output();

        $this->saveLog("Impression des Fiches de recu", array(), array(),array(), true,"Verssements");
        return $pdf->stream();
    }
    
    
    
    

    public function ficheVerssement(){
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->titles = "Fiche de scolarité";
        View::share('title', $this->titles);
        View::share('option_route', route("scolarite"));

        $annee = Anneeacademique::all();
        $filiere = Filiere::all();


        return  view("scolarite.print")
            ->with("annee", $annee)
            ->with("filiere", $filiere);
    }

    public function printFicheVerssement(Request $request){
        $request->validate([
            "specialite"=>"required",
            "annee"=>"required",
        ]);

        $annee = $request->input("annee");
        $specialite = $request->input("specialite");

        if($specialite!="all" && isset($annee)){
            $scolarite = Scolarite::where("specialite_id" , "=", $specialite)->where("anneeacademique_id", "=", $annee)->orderBy("montantScolarite")->get();
            $Specialite = Specialite::where("id", "=", $annee)->first();
        }else{
            if($specialite!="all"){
                $scolarite = Scolarite::where("specialite_id" , "=", $specialite)->orderBy("montantScolarite")->get();
                $Specialite = Specialite::where("id", "=", $annee)->first();
            }
            if(isset($annee)){
                $scolarite = Scolarite::where("anneeacademique_id", "=", $annee)->orderBy("montantScolarite")->get();
                $specialite = Specialite::all();
            }
        }

        $annee = Anneeacademique::where("id", "=", $annee)->first();


        $data = array(
            "annee" => $annee,
            "specialite" => $specialite,
            "scolarite" => $scolarite,
            "school" => Etablissement::all()->first()
        );

        $pdf = PDFS::loadView('pdf.ficheScolarite',  $data);
        $pdf->setPaper('a4');
        $pdf->output();

        $this->saveLog("Impression des Fiches de scolarité", array("annee"=>json_encode($annee), "specialite"=>json_encode($specialite)), array(),array(), true,"NOTES");
        return $pdf->stream();
    }


    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="scolarite-versement" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}