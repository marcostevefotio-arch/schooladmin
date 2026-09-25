<?php

namespace App\Http\Controllers;

use App\Models\Ecole;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class EcoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware("auth");
        $this->parent = "Parametres";
        $this->titles = "Ecoles";
        $menu = Menu::where("code_menu", "=", "homesettings")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("diplome-list"));
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

        $data = Ecole::all();

        $this->saveLog(1, array(), array(), array(), true, "ECOLES");

        return view('ecole/list')->with("data", $data);
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

        return view('ecole/form');
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
            "codeEcoles" => "required|unique:ecoles",
            "nomEcole" => "required|unique:ecoles",
        ]);

        $data = new Ecole();
        $data->codeEcoles = $request->input("codeEcoles");
        $data->nomEcole = $request->input("nomEcole");
        $data->save();


        $this->saveLog(2, array(), array(), array(), true, "ECOLES");

        Session::flash('message', 'Ecole enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');


        return redirect()->route("ecole-list");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ecole  $ecole
     * @return \Illuminate\Http\Response
     */
    public function show(Ecole $ecole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ecole  $ecole
     * @return \Illuminate\Http\Response
     */
    public function edit($ecole)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Ecole::find($ecole);

        return view('ecole/form')->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ecole  $ecole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ecole)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $request->validate([
            "codeEcoles" => "required",
            "nomEcole" => "required",
        ]);

        $data = Ecole::find($ecole);
        $data->codeEcoles = $request->input("codeEcoles");
        $data->nomEcole = $request->input("nomEcole");
        $data->update();


        $this->saveLog(4, array(), array(), array(), true, "ECOLES");

        Session::flash('message', 'Ecole modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');


        return redirect()->route("ecole-list");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ecole  $ecole
     * @return \Illuminate\Http\Response
     */
    public function destroy($ecole)
    {

        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Ecole::find($ecole);
        $data->delete();

        $this->saveLog(5, array(), array(), array(), true, "ECOLES");

        Session::flash('message', 'Ecole supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("ecole-list");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="ecole-list" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
