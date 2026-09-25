<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class GradeController extends Controller
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
        $this->titles = "Grades";
        $menu = Menu::where("code_menu", "=", "homesettings")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("grade-list"));
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

        $data = Grade::all();

        $this->saveLog(1, array(), array(), array(), true, "GRADES");

        return view('grade/list')->with("data", $data);
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

        return view('grade/form');
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
            "codeGrade" => "required|unique:grades",
            "intituleGrade" => "required|unique:grades",
        ]);

        $data = new Grade();
        $data->codeGrade  = $request->input("codeGrade");
        $data->intituleGrade  = $request->input("intituleGrade");
        $data->save();


        $this->saveLog(2, array(), array(), array(), true, "GRADES");

        Session::flash('message', 'Grade enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');


        return redirect()->route("grade-list");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($grade)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Grade::find($grade);

        return view('grade/form')->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $grade)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $request->validate([
            "codeGrade" => "required",
            "intituleGrade" => "required",
        ]);

        $data = Grade::find($grade);
        $data->codeGrade  = $request->input("codeGrade");
        $data->intituleGrade  = $request->input("intituleGrade");
        $data->update();


        $this->saveLog(4, array(), array(), array(), true, "GRADES");

        Session::flash('message', 'Grade modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');


        return redirect()->route("grade-list");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($grade)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Grade::find($grade);
        $data->delete();

        $this->saveLog(5, array(), array(), array(), true, "GRADES");

        Session::flash('message', 'Grade supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("grade-list");
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="grade-list" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
