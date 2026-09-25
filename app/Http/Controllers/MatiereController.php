<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Menu;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\Typeue;
use App\Models\Ue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des filières";
        $this->titles = "Elements Constitutifs";
        $menu = Menu::where("code_menu", "=", "homefiliere")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("matiere"));
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

        $data = Matiere::all();
//        echo json_encode($data);
        $this->saveLog(1, array(), array(),array(), true,"EC");
        return view("matieres.list")->with("data", $data);
    }

    public function ajaxJsonMatieres(Request $request)
    {
        $specialite = $request->input("specialite");

        $data = Ue::select("ues.*", "matieres.*", "matieres.id as ecID")
            ->where("specialite_id", $specialite)
            ->join("matieres", "matieres.ue_id", "=", "ues.id")
            ->get();
        return response()->json($data);
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

        $ues = Ue::all();

        return view("matieres.form")->with("ues", $ues);
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
            "ue"=>"required",
            "codeMatiere"=>"required|unique:matieres",
            "libelleMatiere"=>"required|unique:matieres",
        ]);

        $ue= Ue::find($request->input("ue"));

        $matiere = new Matiere();
        $matiere->codeMatiere = $request->input("codeMatiere");
        $matiere->libelleMatiere = $request->input("libelleMatiere");
        $matiere->descriptionMatiere = $request->input("descriptionMatiere");
        $ue->matiere()->save($matiere);

        $this->saveLog(2, $matiere, array(),array(), true,"EC");
        Session::flash('message', 'EC Enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
        return redirect()->route("matiere")->with("success", "success");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function show($matiere)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Matiere::where("id", "=", $matiere)->first();
        $this->saveLog(3, $matiere, array(),array(), true,"EC");
        return view("matieres.read")->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($matiere)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $spes = Specialite::all();
        $sems = Semestre::all();
        $ues = Ue::all();
        $data = Matiere::where("id", "=", $matiere)->first();
        return view("matieres.form")->with('data', $data)->with("spes", $spes)->with("sems", $sems)->with("ues", $ues);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $matiere)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $request->validate([
            "ue"=>"required",
            "codeMatiere"=>"required",
            "libelleMatiere"=>"required",
        ]);



        $matiere = Matiere::where("id", "=", $matiere)->first();
        $matiere->codeMatiere = $request->input("codeMatiere");
        $matiere->libelleMatiere = $request->input("libelleMatiere");
        $matiere->descriptionMatiere = $request->input("descriptionMatiere");
        $matiere->update();

        $this->saveLog(4, $matiere, array(),array(), true,"EC");

        Session::flash('message', 'EC Modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("matiere")->with("success", "success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function destroy($matiere)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Matiere::where("id", "=", $matiere)->first();
        $data->delete();


        $this->saveLog(5, $matiere, array(),array(), true,"EC");

        Session::flash('message', 'EC Supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
        return redirect()->route("matiere");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="filiere-ec" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
