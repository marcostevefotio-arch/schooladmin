<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\Typeue;
use App\Models\Ue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class UeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des filières";
        $this->titles = "Unites d'enseignements";
        $menu = Menu::where("code_menu", "=", "homefiliere")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("ue"));
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

        $ue = Ue::all();
        $this->saveLog(1, $ue, array(),array(), true,"UE");

        return view("ue.list")->with("ue", $ue);
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

        $specialite = Specialite::all();
        $semestre = Semestre::all();
        $typeue = Typeue::all();
        return view("ue.form")->with("specialite", $specialite)->with("semestre", $semestre)->with("ues", $typeue);
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
            "specialite"=>"required",
            "semestre"=>"required",
            "ue"=>"required",
            "codeue"=>"required|unique:ues",
            "libelleue"=>"required|unique:ues",
            "total"=>"required|min:1",
            "credit"=>"required|min:1",
        ]);


        $data = new Ue();
        $data->specialite_id = Specialite::where("codeSpecialite","=",$request->input("specialite"))->first()->id;
        $data->typeue_id =  $request->input('ue');
        $data->semestre_id =  $request->input('semestre');
        $data->codeUE =  $request->input('codeue');
        $data->libelleUe =  $request->input('libelleue');
        $data->total =  $request->input('total');
        $data->credit =  $request->input('credit');
        $data->cm = !empty($request->input("cm"))? $request->input("cm") : 0;
        $data->td = !empty($request->input("td"))? $request->input("td") : 0;
        $data->tp = !empty($request->input("tp"))? $request->input("tp") : 0;
        $data->tpe = !empty($request->input("tpe"))? $request->input("tpe") : 0;
        $data->save();

        $this->saveLog(1, $data, array(),$data, true,"UE");

        Session::flash('message', 'Ue enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
        return redirect()->route("ue");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ue  $ue
     * @return \Illuminate\Http\Response
     */
    public function show(Ue $ue)
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
     * @param  \App\Models\Ue  $ue
     * @return \Illuminate\Http\Response
     */
    public function edit($ue)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $spes = Specialite::all();
        $sems = Semestre::all();
        $ues = Typeue::all();
        $data = Ue::where("id", "=", $ue)->first();
        return view("ue.form")->with('data', $data)->with("specialite", $spes)->with("semestre", $sems)->with("ues", $ues);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ue  $ue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ue)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $request->validate([
            "specialite"=>"required",
            "semestre"=>"required",
            "ue"=>"required",
            "codeue"=>"required",
            "libelleue"=>"required",
            "total"=>"required|min:1",
            "credit"=>"required|min:1",
        ]);


        $data = Ue::where("id", "=", $ue)->first();
        $data->specialite_id = Specialite::where("codeSpecialite","=",$request->input("specialite"))->first()->id;
        $data->typeue_id =  $request->input('ue');
        $data->semestre_id =  $request->input('semestre');
        $data->codeUE =  $request->input('codeue');
        $data->libelleUe =  $request->input('libelleue');
        $data->total =  $request->input('total');
        $data->credit =  $request->input('credit');
        $data->cm = !empty($request->input("cm"))? $request->input("cm") : 0;
        $data->td = !empty($request->input("td"))? $request->input("td") : 0;
        $data->tp = !empty($request->input("tp"))? $request->input("tp") : 0;
        $data->tpe = !empty($request->input("tpe"))? $request->input("tpe") : 0;

        $data->update();
        $this->saveLog(4, $ue, array(),array(), true,"UE");

        Session::flash('message', 'Ue modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("ue");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ue  $ue
     * @return \Illuminate\Http\Response
     */
    public function destroy($ue)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }//

        $data = Ue::where("id", "=", $ue)->first();
        $data->delete();
        $this->saveLog(5, $ue, array(),array(), true,"UE");

        Session::flash('message', 'Ue supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("ue");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="filiere-ue" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
