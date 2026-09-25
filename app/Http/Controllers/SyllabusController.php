<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Menu;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\Syllabus;
use App\Models\Ue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class SyllabusController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des filières";
        $this->titles = "Syllabus";
        $menu = Menu::where("code_menu", "=", "homefiliere")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("syllabus"));
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
        $this->saveLog(1, array(), array(),array(), true,"Syllabus");
        return view("syllabus.list")->with("data", $data);
    }


    public function ajaxJsonSyllabus(Request $request)
    {
        $matiere = $request->input("matiere");

        $data = Matiere::select("matieres.*", "syllabus.*", "syllabus.id as syllabusID")
            ->where("matiere_id", $matiere)
            ->join("syllabus", "syllabus.matiere_id", "=", "matieres.id")
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

        $spes = Specialite::all();
        return view("syllabus.form")->with("spes", $spes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $request->validate([
            "matiere"=>"required",
            "titleSyllabus"=>"required",
        ]);

        $syllabus = new Syllabus();
        $syllabus->codeSyllabus = Str::random(20);
        $syllabus->matiere_id = $request->input("matiere");
        $syllabus->titleSyllabus = $request->input("titleSyllabus");

        $text = $request->input("descriptionSyllabus");
        $text = trim($text); // remove the last \n or whitespace character
        $text = nl2br($text);
        $text = "<p>".$text."</p>";
        $syllabus->descriptionSyllabus = $text;
        $syllabus->save();

        $this->saveLog(2, $syllabus, array(),array(), true,"Syllabus");

        Session::flash('message', 'Syllabus enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("syllabus")->with("success", "success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function show($syllabus)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Matiere::where("id", "=", $syllabus)->first();
        $this->saveLog(3, $syllabus, array(),array(), true,"Syllabus");
        return view("syllabus.read")->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function edit($syllabus)
    {
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $spes = Specialite::all();
        $data = Syllabus::where("id", $syllabus)->first();
        return view("syllabus.form")->with('data', $data)->with("spes", $spes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $syllabus)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $request->validate([
            "matiere"=>"required",
            "titleSyllabus"=>"required",
        ]);

        $syllabus = Syllabus::where("id", "=", $syllabus)->first();
        $syllabus->matiere_id = $request->input("matiere");
        $syllabus->titleSyllabus = $request->input("titleSyllabus");
        $syllabus->descriptionSyllabus = $request->input("descriptionSyllabus");
        $syllabus->update();

        $this->saveLog(4, $syllabus, array(),array(), true,"Syllabus");

        Session::flash('message', 'Syllabus Modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->back()->with("success", "success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function destroy($syllabus)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Syllabus::where("matiere_id", "=", $syllabus)->get();

        foreach ($data as $d){
            $d->delete();
        }


        $this->saveLog(5, $syllabus, array(),array(), true,"Syllabus");

        Session::flash('message', 'Syllabus Supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
        return redirect()->route("syllabus");
    }


    public function destroyOnce($syllabus)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Syllabus::where("id", "=", $syllabus)->first();
        $data->delete();


        $this->saveLog(5, $syllabus, array(),array(), true,"Syllabus");

        Session::flash('message', 'Syllabus Supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
        return redirect()->route("syllabus");
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
