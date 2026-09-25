<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Menu;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class SpecialiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des filières";
        $this->titles = "Spécialités";
        $menu = Menu::where("code_menu", "=", "homefiliere")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("filiere"));
        View::share('active', "homefiliere");
    }



    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Specialite::all();

        $this->saveLog(1, array(), array(),array(), true,"SPECIALITES");

        return view("specialite.list")->with("data", $data);
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

        $filieres = Filiere::all();

        return view("specialite.form")->with("filiere", $filieres);
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
            "filiere"=>"required",
            "codeSpecialite"=>"required|unique:specialites",
            "libelleSpecialite"=>"required|unique:specialites",
        ]);

        $specialite = new Specialite();
        $specialite->filiere_id = $request->input("filiere");
        $specialite->codeSpecialite = $request->input("codeSpecialite");
        $specialite->libelleSpecialite = $request->input("libelleSpecialite");
        $specialite->descriptionSpecialite = $request->input("description");
        $specialite->save();

        $this->saveLog(2, $specialite, array(),array(), true,"SPECIALITES");

        return redirect()->route("specialite")->with("success", "success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specialite  $specialite
     * @return \Illuminate\Http\Response
     */
    public function show(Specialite $specialite)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->saveLog(3, $specialite, array(),array(), true,"SPECIALITES");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specialite  $specialite
     * @return \Illuminate\Http\Response
     */
    public function edit($specialite)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Specialite::where('id', '=', $specialite)->first();
        $filiere = Filiere::all();

        return view("specialite.form")->with("data", $data)->with("filiere", $filiere);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialite  $specialite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sp)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $request->validate([
            "filiere"=>"required",
            "codeSpecialite"=>"required",
            "libelleSpecialite"=>"required",
        ]);

        $specialite = Specialite::where("id", "=", $sp)->first();
        $specialite->filiere_id = $request->input("filiere");
        $specialite->codeSpecialite = $request->input("codeSpecialite");
        $specialite->libelleSpecialite = $request->input("libelleSpecialite");
        $specialite->descriptionSpecialite = $request->input("description");
        $specialite->update();

        $this->saveLog(4, $specialite, array(),array(), true,"SPECIALITES");

        return redirect()->route("specialite")->with("success", "success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialite  $specialite
     * @return \Illuminate\Http\Response
     */
    public function destroy($sp)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $specialite = Specialite::where("id", "=", $sp)->first();
        $specialite->delete();

        $this->saveLog(5, $specialite, array(),array(), true,"SPECIALITES");

        return redirect()->route("specialite")->with("success", "success");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="filiere-specialite" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
