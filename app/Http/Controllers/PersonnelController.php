<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Menu;
use App\Models\Parametre;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PersonnelController extends Controller
{

    private $titles;
    private $parent;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion de la sécurité";
        $this->titles = "Utilisateurs";
        $menu = Menu::where("code_menu", "=", "homesecurite")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("user"));
        View::share('active', "homesecurite");
    }

    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->saveLog(1, array(), array(),array(), true,"PERSONNEL");
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

        $groupe = Groupe::all();
        return view("personnel.form")->with("groupe", $groupe);
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
            "groupe"=>"required",
            "lastname"=>"required",
            "firstname"=>"required",
            "sexe"=>"required",
            "birthday"=>"required",
            "cni"=>"required|unique:personnels"
        ]);

        $personnel = new Personnel();
        $personnel->groupe_id = $request->input('groupe');
        $personnel->code = date("Ymdhis")."-".$request->input('cni');
        $personnel->lastname = $request->input('lastname');
        $personnel->firstname = $request->input('firstname');
        $personnel->sexe = $request->input('sexe');
        $personnel->birthday = $request->input('birthday');
        $personnel->cni = $request->input('cni');
        $personnel->country = $request->input('country');
        $personnel->adresse = $request->input('address');
        $personnel->phone = $request->input('phone');


        $createAccount = $request->input("createUser");
        if(isset($createAccount)){
            $request->validate([
                "email"=>"required|email|unique:users",
            ]);

            $parametre = Parametre::where("option", "=", "Mot de passe")->first();
            if(!empty($parametre)){

                $personnel->save();

                $user = new User();
                $user->personnel_id = $personnel->id;
                $user->codeUser = Str::random(20);
                $user->email = $request->input("email");
                $user->password = Hash::make($parametre->valeur);
                $user->save();

                $this->saveLog(2, array(), array(),$user, true,"User");
                Session::flash('message', 'Compte utilisateur crée avec succès. Utilisez le mot de passe par defaut pour vour connecter');
                Session::flash('alert-class', 'alert-success');
                Session::flash('alert-title', 'Succes');
                return redirect()->route("user");
            }else{
                Session::flash('message', 'Mot de passe par defaut non configuré');
                Session::flash('alert-class', 'alert-warning');
                Session::flash('alert-title', 'Attention');
                return redirect()->back();
            }
        }else{
            $personnel->save();
        }

        $this->saveLog(2, $personnel, array(),array(), true,"PERSONNEL");

        return redirect()->route("user")->with("success", "Enregistrement réussi");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function show(Personnel $personnel)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->saveLog(3, $personnel, array(),array(), true,"PERSONNEL");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function edit(Personnel $personnel)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personnel $personnel)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(4, $personnel, array(),array(), true,"PERSONNEL");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personnel $personnel)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->saveLog(5, $personnel, array(),array(), true,"PERSONNEL");
    }




    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="securite-user" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
