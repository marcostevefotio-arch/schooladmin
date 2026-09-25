<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Historique;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class GroupeController extends Controller
{

    private $titles;
    private $parent;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware("auth");
        $this->parent = "Gestion de la sécurité";
        $this->titles = "Groupes d'utilisateurs";
        $menu = Menu::where("code_menu", "=", "homesecurite")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("groupe"));
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

        $this->parent = "Gestion de la sécurité";
        $this->titles = "Groupes d'utilisateurs";
        $groupe = Groupe::all();

        $this->saveLog(1, array(), array(),$groupe, true,"Groupe");

        return view("security.group.list")
        ->with("groupes", $groupe);
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

        $menu = Menu::where("menu_id", "=", null)->get();
        return view("security.group.form")->with("menu", $menu);
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
            "titre"=>"required |unique:groupes",
        ]);


        $groupe = Groupe::create([
            'codeGroupe' => Str::random(20),
            'titre_groupe' => $request->input('titre'),
            'description_groupe' => $request->input('description'),
        ]);

        if(!empty($groupe)){
            $permission = Permission::all();
            $permission_list = array();
            foreach ($permission as $p){
                if(key_exists("permission_".$p->id, $request->all())){
                    array_push($permission_list, $p->id);
                }
            }

            $groupe->permission()->attach($permission_list);
        }

        $this->saveLog(2, array(), array("groupe"=>$groupe, "permissions"=>$groupe->permission), $groupe, true,"Groupe");

        return redirect()->route("groupe");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function show($groupe)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $groupes = Groupe::find($groupe);
        $menus = Menu::where("menu_id", "=", null)->get();

        $this->saveLog(3, array(), array(), $groupes, true,"Groupe");

        return view("security.group.read")->with("groupes", $groupes)->with("menu", $menus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function edit($groupe)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $groupes = Groupe::find($groupe);
        $menu = Menu::where("menu_id", "=", null)->get();
        return view("security/group/form")->with("groupe", $groupes)->with("menu", $menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $groupe)
    {

        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        Validator::make($request->all(), [
            "titre"=>"required |unique:groupes",
        ]);


        $groupes = Groupe::find($groupe);
        $before = $groupes;

        $groupes->titre_groupe = $request->input('titre');
        $groupes->description_groupe = $request->input('description');

//        echo json_encode($request->all());

        $groupes->permission()->detach();

        $groupes->update();


        if(!empty($groupes)){
            $permission = Permission::all();
            $permission_list = array();
            foreach ($permission as $p){
                $field = $request->input("permission_".$p->id);
                if(isset($field)){
                    array_push($permission_list, $p->id);
                }
            }

            $groupes->permission()->attach($permission_list);

            $after = $groupes;
        }

        $this->saveLog(4, array(), array(), array(), true, "Groupe");

        return redirect()->route("groupe");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Groupe  $groupe
     * @return \Illuminate\Http\Response
     */
    public function destroy($groupe)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $groupes = Groupe::find($groupe);
        $groupes->permission()->detach();
        $groupes->delete();

        $this->saveLog(5, $groupes, array(), $groupes, true,"Groupe");

        return redirect()->route("groupe")->with("success", "Groupe supprimé avec succès");
    }


    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="securite-groupe" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }

}
