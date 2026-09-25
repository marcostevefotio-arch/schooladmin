<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HistoriqueController extends Controller
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
        $this->titles = "Historiques d'activités";
        $menu = Menu::where("code_menu", "=", "homesecurite")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("logs"));
        View::share('active', "homesecurite");
    }


    public function index($log="")
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        if(!empty($log)){
            $historique = Historique::where("user_id", "=", $log)->get();
        }else{
            $historique = Historique::all();
        }
        return view("security.logs.list")->with("logs", $historique);
    }


    public function show($log)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $historique = Historique::where("id", "=", $log)->first();
        return view("security.logs.read")->with("log", $historique);
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="securite-historique" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
