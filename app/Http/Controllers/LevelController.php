<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class LevelController extends Controller
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
        $this->titles = "Niveaux";
        $menu = Menu::where("code_menu", "=", "homesettings")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("level-list"));
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

        $data = Level::all();


        $this->saveLog(1, array(), array(), array(), true, "LEVELS");

        return view('niveau/list')->with("data", $data);
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


        return view('level/form');
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
            "numeroLevel" => "required|unique:levels"
        ]);

        $data = new Level();
        $data->codeLevel = Str::random(20);
        $data->numeroLevel = $request->input("numeroLevel");
        $data->save();

        $this->saveLog(2, array(), array(), array(), true, "LEVELS");

        Session::flash('message', 'Niveau enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("level-list");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show($level)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Level::all();

        return view('niveau/list')->with("data", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit($level)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Level::find($level);

        return view('cycle/form')->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $level)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $request->validate([
            "numeroLevel" => "required|unique:levels"
        ]);

        $data = Level::find($level);
        $data->numeroLevel = $request->input("numeroLevel");
        $data->update();

        $this->saveLog(4, array(), array(), array(), true, "LEVELS");

        Session::flash('message', 'Niveau modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("level-list");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy($level)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Level::find($level);
        $data->delete();

        $this->saveLog(5, array(), array(), array(), true, "LEVELS");

        Session::flash('message', 'Niveau supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("level-list");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="level-list" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
