<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Organigramme;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use function MongoDB\BSON\toJSON;

class OrganigrammeController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion de l'organisation";
        $this->titles = "Organigramme";
        $menu = Menu::where("code_menu", "=", "homeorganisation")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("organisation-list"));
        View::share('active', "homeorganisation");
    }

    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $organisation = Organigramme::whereNull("organisation_id")->get();
        $organisationAll = Organigramme::all();
        $data = [];

        $this->saveLog(5, array(), array(),array(), true,"ORGANISATIONS");

        return view("organigramme/list")->with("data", $organisationAll);
    }


    public function create()
    {
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $organisation = Organigramme::all();
        $personnel = Personnel::all();
        $data = [
            "org" => $organisation,
            "personnel" => $personnel
        ];

        return view("organigramme/form")->with("data", $data);
    }



    public function store(Request $request)
    {
        if(!in_array("create", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $validation = $this->validate($request, [
           "title"=>"required|string|max:255",
           "description"=>"string|max:255",
        ]);


        $organigramme = new Organigramme();
        $organigramme->organisation_id = $request->input("parent");
        $organigramme->user_id = $request->input("responssable");
        $organigramme->codeOrganisation = Str::random(20);
        $organigramme->organisationTitle = $request->input("title");
        $organigramme->organisationDescription = $request->input("description");
        $organigramme->save();

        $this->saveLog(2, $organigramme, array(),array(), true,"ORGANISATIONS");

        Session::flash('message', 'Enregistrement de l\'organisation effectué avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("organigramme")->with("success","Organisation cree avec success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organigramme  $organigramme
     * @return \Illuminate\Http\Response
     */
    public function show(Organigramme $organigramme)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(3, $organigramme, array(),array(), true,"ORGANISATIONS");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organigramme  $organigramme
     * @return \Illuminate\Http\Response
     */
    public function edit($organigramme)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }



        $org = Organigramme::where("id", "=", $organigramme)->first();

        $organisation = Organigramme::all();
        $personnel = Personnel::all();
        $data = [
            "org" => $organisation,
            "personnel" => $personnel,
            "data" => $org,
        ];

        return view("organigramme/form")->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organigramme  $organigramme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $org)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $validation = $this->validate($request, [
            "title"=>"required|string|max:255",
            "description"=>"string|max:255",
        ]);


        $organigramme = Organigramme::where("id", "=", $org)->first();
        $organigramme->organisation_id = $request->input("parent");
        $organigramme->user_id = $request->input("responssable");
        $organigramme->organisationTitle = $request->input("title");
        $organigramme->organisationDescription = $request->input("description");
        $organigramme->update();


        $this->saveLog(4, $organigramme, array(),array(), true,"ORGANISATIONS");

        Session::flash('message', 'Modification de l\'organisation effectué avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->route("organigramme");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organigramme  $organigramme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organigramme $organigramme)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $org = Organigramme::where("id", "=", $organigramme)->first();
        $org->delete();

        $this->saveLog(5, $organigramme, array(),array(), true,"ORGANISATIONS");

        Session::flash('message', 'Organisation supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');

        return redirect()->back();
    }

    public function organisationList(){

        $organisation = Organigramme::whereNull("organisatiorn_id")->get();

        $data = $this->buildTree($organisation);

        return response()->json($data);
    }

    public function buildTree($data){
        $datas = array();
        foreach ($data as $d){
//            if(in_array($d->organisation_id, $datas)){
//                if(isset($datas[$d->organisation_id]["additionalParameters"])) {
//                    array_push($datas[$d->organisation_id]["additionalParameters"], [$d->id => ["text" => $d->organisationTitle, "type" => "folder"]]);
//                }
//            }else{
//                $jsonResponse .= "".$d->organisationTitle.":{text:".$d->organisationTitle.", type:folder},";
                array_push($datas, array(str_replace(" ","-",$d->organisationTitle)=>array("text"=>$d->organisationTitle,"type"=>"folder")));
//            }
        }

        return response()->json($datas);

    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="organisation-list" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
