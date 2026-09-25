<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\Menu;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Paremetres";
        $this->titles = "Parametres d'application";
        $menu = Menu::where("code_menu", "=", "homesettings")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("organisation-parametre"));
        View::share('active', "homesettings");
    }


    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Etablissement::all()->first();
        $parametre = Parametre::all();
        $this->saveLog(1, array(), array(),array(), true,"ETABLISSEMENT");
        return view("etablissement.list")->with("data", $data)->with("param", $parametre);
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
        $this->saveLog(2, array(), array(),array(), true,"ETABLISSEMENT");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Etablissement  $etablissement
     * @return \Illuminate\Http\Response
     */
    public function show(Etablissement $etablissement)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(3, array(), array(),array(), true,"ETABLISSEMENT");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Etablissement  $etablissement
     * @return \Illuminate\Http\Response
     */
    public function edit($etablissement)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Etablissement::where("id","=",$etablissement)->first();
        return view("etablissement.form")->with("data", $data);
    }


    public function paramEdit($param)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $data = Parametre::where("id","=",$param)->first();
        return view("etablissement.paramform")->with("data", $data);
    }


    public function update(Request $request, $etablissement)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Etablissement::where("id","=",$etablissement)->first();
        $data->scoolname = $request->input("etname");
        $data->schoolEmail = $request->input("etemail");
        $data->schoolPhone = $request->input("etphone");
        $data->schoolPobox = $request->input("etpobox");
        $data->schoolAdresse = $request->input("etadresse");
        $data->schoolSite = $request->input("etsite");

        $data->update();
        $this->saveLog(4, array(), array(),array(), true,"ETABLISSEMENT");

        return redirect()->route("etablissement")->with("success", "success");
    }


    public function paramUpdate(Request $request, $param)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Parametre::where("id","=",$param)->first();
        $data->description = $request->input("description");
        $data->valeur = $request->input("valeur");

        $data->update();
        $this->saveLog(4, array(), array(),array(), true,"ETABLISSEMENT");

        return redirect()->route("etablissement")->with("success", "success");
    }


    public function destroy(Etablissement $etablissement)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(5, array(), array(),array(), true,"ETABLISSEMENT");
    }

    public function logochange(Request $request){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        Validator::make($request->all(),[
            "image" => "requred|mime:png|max:2048"
        ]);

        $request->file("image")->move("assets/images/logo","issat.png");
        $this->saveLog("CHANGEMENT DU LOGO", array(), array(),array(), true,"ETABLISSEMENT");

        return redirect()->route("etablissement")->with("success", "success");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="organisation-parametre" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
