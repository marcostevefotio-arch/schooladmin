<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
    }


    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Classe::all();
        $this->saveLog(1, array(), array(),array(), true,"CLASSE");
        return view("classes.list")->with("data", $data);
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

        $filiere = Filiere::all();
        $specialite = Specialite::all();
        return view("classes.form")->with("filiere", $filiere)->with("specialite", $specialite);
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


        Validator::make($request->all(), [
           "specialite"=>"required",
           "libelleClasse"=>"required|unique:classes",
        ]);

        $classe = new Classe();
        $classe->codeClasse = Str::random(20);
        $classe->specialite_id = $request->input("specialite");
        $classe->libelleClasse = $request->input("libelleClasse");
        $classe->descriptionClasse = $request->input("description");
        $classe->save();

        $this->saveLog(2, $classe, array(),array(), true,"CLASSE");

        return redirect()->route("classe")->with("success", "success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function show(Classe $classe)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(3, $classe, array(),array(), true,"CLASSE");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function edit($cl)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $data = Classe::where("id", "=", $cl)->first();
        $filiere = Filiere::all();
        $specialite = Specialite::all();
        return view("classes.form")->with("data", $data)->with("filiere", $filiere)->with("specialite", $specialite);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cl)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        Validator::make($request->all(), [
            "specialite"=>"required",
            "libelleClasse"=>"required",
        ]);

        $classe = Classe::where("id", "=", $cl)->first();
        $classe->specialite_id = $request->input("specialite");
        $classe->libelleClasse = $request->input("libelleClasse");
        $classe->descriptionClasse = $request->input("description");
        $classe->update();

        $this->saveLog(4, $cl, array(),$classe, true,"CLASSE");
        return redirect()->route("classe")->with("success", "success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function destroy($cl)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $classe = Classe::where("id", "=", $cl)->first();
        $classe->delete();
        
        $this->saveLog(5, array(), array(),array(), true,"CLASSE");

        return redirect()->route("classe")->with("success", "success");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="filiere-list" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
