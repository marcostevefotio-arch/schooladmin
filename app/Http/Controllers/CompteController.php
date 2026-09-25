<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Menu;
use App\Models\Verssement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CompteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion de la scolarité";
        $this->titles = "Compte";
        $menu = Menu::where("code_menu", "=", "homescolarite")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("compte"));
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

        $compte = Compte::all();
        return  view("compte.list")->with("compte", $compte);
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

        $this->titles = "Comptes";
        View::share('title', $this->titles);
        View::share('option_route', route("compte"));

        return  view("compte.form");
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
            "codeCompte"=>"required|unique:comptes",
            "libelleCompte"=>"required",
        ]);

        $compte = new Compte();
        $compte->codeCompte = $request->input("codeCompte");
        $compte->libelleCompte = $request->input("libelleCompte");
        $compte->descriptionCompte = $request->input("descriptionCompte");
        $compte->save();

        Session::flash('message', 'Compte enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');

        return redirect()->route("compte");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function show($compte)
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
    public function edit($compte)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $compte = Compte::where("id", "=", $compte)->first();
        return  view("compte.form")->with("data", $compte);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $compte)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $request->validate([
            "codeCompte"=>"required|unique:comptes",
            "libelleCompte"=>"required",
        ]);

        $compte = Compte::where("id", "=", $compte)->first();
        $compte->codeCompte = $request->input("codeCompte");
        $compte->libelleCompte = $request->input("libelleCompte");
        $compte->descriptionCompte = $request->input("descriptionCompte");
        $compte->update();

        Session::flash('message', 'Compte modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');

        return redirect()->route("compte");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function destroy($compte)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $compte = Compte::where("id", "=", $compte)->first();
        $compte->delete();

        Session::flash('message', 'Compte Supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->route("compte");
    }


    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="scolarite-compte" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
