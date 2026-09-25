<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Frai;
use App\Models\Inscription;
use App\Models\Menu;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class FraiController extends Controller
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

        $verssement = Frai::all();
        return  view("scolarite.list")->with("frais", $verssement);
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

        $this->titles = "Verssement";
        View::share('title', $this->titles);
        View::share('option_route', route("scolarite"));
        $filiere = Filiere::all();


        return  view("scolarite.form")->with("filiere", $filiere);
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
            "etudiants"=>"required",
            "montant"=>"required|min:1",
            "dateverssement"=>"required|before:".date("Y-m-d"),
        ]);

        $inscription = Inscription::where('etudiant_id', "=", $request->input("etudiants"))->first();

        $frais = new Frai();
        $frais->inscription_id = $inscription->id;
        $frais->codeFrais = Str::random(20);
        $frais->montant = $request->input("montant");
        $frais->dateverssement = $request->input("dateverssement");
        $frais->motif = $request->input("motif");

//        var_dump($frais);
        $frais->save();

        Session::flash('message', 'Verssement enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');

        return redirect()->route("scolarite");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frai  $frai
     * @return \Illuminate\Http\Response
     */
    public function show(Frai $frai)
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
     * @param  \App\Models\Frai  $frai
     * @return \Illuminate\Http\Response
     */
    public function edit(Frai $frai)
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
     * @param  \App\Models\Frai  $frai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $frais = Frai::find($id);
        $frais->deuxieme = (($frais->deuxieme + $request->input("premiere")) >= $frais->total)? $frais->total :  ($frais->deuxieme + $request->input("premiere"));
        $frais->etat = ($frais->deuxieme >= $frais->total)? true : false;
        $frais->update();

        return redirect()->route("inscriptionShow", ["slug"=>$frais->inscription->id])->with("success", "Paiement enregistré");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frai  $frai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Frai $frai)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
    }



    public function config(){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $errors = false;
        $jsonFraisConfig = base_path('resources/configs');
        if(!File::isDirectory($jsonFraisConfig)){
            File::makeDirectory($jsonFraisConfig);

            $jsonFraisConfig.="/frais_".date("Y").".json";
            if(File::isFile($jsonFraisConfig)){
                $file =  File::get($jsonFraisConfig);
                $filesend = json_decode($file, true);
            }else{
                File::put($jsonFraisConfig, []);

                $file =  File::get($jsonFraisConfig);
                $filesend = json_decode($file, true);
                $errors = true;
            }
        }else{
            $jsonFraisConfig.="/frais_".date("Y").".json";
            if(File::isFile($jsonFraisConfig)){
                $file =  File::get($jsonFraisConfig);
                $filesend = json_decode($file, true);
            }else{
                File::put($jsonFraisConfig, []);

                $file =  File::get($jsonFraisConfig);
                $filesend = json_decode($file, true);
                $errors = true;
            }

        }

        if(is_null($filesend)){
            $errors = true;
        }

        $filiere = Filiere::all();


        $this->titles = "Configuration";
        View::share('title', $this->titles);
        View::share('option_route', route("scolarite-solvabilite"));


        if($errors){
            Session::flash('message', 'Configurer dabors les frais de scolarités');
            Session::flash('alert-class', 'alert-warning');
            Session::flash('alert-title', 'Attention');
        }

        return view("scolarite.config")->with("config", (is_null($filesend)? [] : $filesend))->with("filiere", $filiere);
    }


    public function config_save(Request $request){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $request->validate([
           "specialite"=>"required",
           "type"=>"required",
           "montant"=>"required|min:0",
           "description"=>"required",
        ]);

        $sp_id = $request->input("specialite");
        $type = $request->input("type");
        $montant = $request->input("montant");
        $description = $request->input("description");


        $specialite = Specialite::find($sp_id);

        $jsonFraisConfig = base_path('resources/configs');
        if(!File::isDirectory($jsonFraisConfig)){
            File::makeDirectory($jsonFraisConfig);
        }

        $jsonFraisConfig.="/frais_".date("Y").".json";

        $jsonadd =  File::get($jsonFraisConfig);
        $jsonadd = json_decode($jsonadd, true);

        $scolarite = array(
            "year"=> date("Y"),
            "specialite_id"=> $specialite->id,
            "specialite_name"=> $specialite->libelleSpecialite,
            "type"=> $type,
            "montant"=> $montant,
            "description"=> $description,
        );

        if(is_null($jsonadd)){
            $jsonadd = array(
                $type=="scolarite"? $type."_".$specialite->id : str_replace(" ","_", $description)."_".$specialite->id => $scolarite,
            );

            $data = json_encode($jsonadd);
            var_dump($data);
            File::append($jsonFraisConfig, $data);
        }else{
            if($type=="scolarite"){
                $jsonadd[ $type."_".$specialite->id] = $scolarite;
            }else{
                $jsonadd[ str_replace(" ","_", $description)."_".$specialite->id] = $scolarite;
            }

            $data = json_encode($jsonadd);
            File::put($jsonFraisConfig, $data);
        }

        Session::flash('message', 'Configuration de la scolarité enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->route("scolarite-configuration");
    }


    public function solvabilite($annee=""){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->titles = "Solvabilité";
        View::share('title', $this->titles);
        View::share('option_route', route("scolarite-solvabilite"));

        $inscription = Inscription::where("year","=", $annee)->get();
        return view("scolarite.solvabilite")->with("etudiants", $inscription);
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
