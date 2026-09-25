<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class NavigationController extends Controller
{

    public $title;

    public function __construct(){
        $this->middleware("auth");
        $title = "";
    }

    public function inscription(){
        $this->title = "Gestion des inscriptions";
        $menu = Menu::where("code_menu", "=", "homeinscription")->first();
        $active = "homeinscription";
        return view("homeinscription")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function etudiants(){
        $this->title = "Gestion des étudiants";
        $menu = Menu::where("code_menu", "=", "homeetudiant")->first();
        $active = "homeetudiant";
        return view("homeetudiant")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function enseignant(){
        $this->title = "Gestion des enseignants";
        $menu = Menu::where("code_menu", "=", "homeenseignant")->first();
        $active = "homeenseignant";
        return view("homeenseignant")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function notes(){
        $this->title = "Gestion des notes";
        $menu = Menu::where("code_menu", "=", "homenote")->first();
        $active = "homenote";
        return view("homenote")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function filiere(){
        $this->title = "Gestion des filières";
        $menu = Menu::where("code_menu", "=", "homefiliere")->first();
        $active = "homefiliere";
        return view("homefiliere")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function organisation(){
        $this->title = "Gestion de l'organisation";
        $menu = Menu::where("code_menu", "=", "homeorganisation")->first();
        $active = "homeorganisation";
        return view("homeorganisation")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function securite(){
        $this->title = "Gestion de la sécurité";
        $menu = Menu::where("code_menu", "=", "homesecurite")->first();
        $active = "homesecurite";
        return view("homesecurite")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function scolarite(){
        $this->title = "Gestion de la scolarité";
        $menu = Menu::where("code_menu", "=", "homescolarite")->first();
        $active = "homescolarite";
        return view("homescolarite")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function planing(){
        $this->title = "Gestion des planings";
        $menu = Menu::where("code_menu", "=", "homeplaning")->first();
        $active = "homeplaning";
        return view("homeplaning")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
    }

    public function settings(){
        $this->title = "Parametres";
        $menu = Menu::where("code_menu", "=", "homesettings")->first();
        $active = "homesettings";
        return view("homesettings")
            ->with("module", $menu)
            ->with("active", $active)
            ->with("title", $this->title);
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
