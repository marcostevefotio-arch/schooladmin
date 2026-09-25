<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use App\Models\Disponibilite;
use App\Models\Enseignant;
use App\Models\Enseignantmatiere;
use App\Models\Etablissement;
use App\Models\Grade;
use App\Models\Matiere;
use App\Models\Menu;
use App\Models\Parametre;
use App\Models\Pays;
use App\Models\Region;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Image;

class EnseignantController extends Controller
{

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des enseignants";
        $this->titles = "Effectfs des enseignants";
        $menu = Menu::where("code_menu", "=", "homeenseignant")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("enseignant-list"));
        View::share('active', "homeenseignant");
    }

    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Enseignant::all();
        $this->saveLog(1, array(), array(),array(), true,"ENSEIGNANTS");
        return view("enseignants.liste")->with("data", $data);
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

        $pays = Pays::orderBy("codePays")->get();
        $region = Region::orderBy("nomRegion")->get();
        $diplome = Diplome::orderBy("intuleDiplome")->get();
        $grade = Grade::orderBy("intituleGrade")->get();

        $this->titles = "Enregistrement d'un enseignant";
        View::share('title', $this->titles);
        return view("enseignants.form")
            ->with("pays", $pays)
            ->with("diplome", $diplome)
            ->with("grade", $grade);
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

        $validate = Validator::make($request->all(),[
//           "firstname" => "required",
           "lastname" => "required",
           "sexe" => "required",
           "nationality" => "required",
           "phone" => "required",
           "specialite" => "required",
           "email" => "required|unique:enseignants",
        ]);


        if($validate->fails()){
            return redirect()->route("enseignantForm")->withInput($request->all())->withErrors($validate->errors());
        }else{

            $param = Parametre::all();
            $pass = $param[0]->valeur;


            $enseignant = new Enseignant();
            $enseignant->codeEnseignant = Str::random(20);
            $enseignant->lastname = $request->input("lastname");
            $enseignant->firstname = $request->input("firstname");
            $enseignant->sexe = $request->input("sexe");
            $enseignant->nationality = $request->input("nationality");
            $enseignant->phonenumber = $request->input("phone");
            $enseignant->diplome = $request->input("diplome");
            $enseignant->grade = $request->input("grade");
            $enseignant->specialite = $request->input("specialite");
            $enseignant->email = $request->input("email");
            $enseignant->save();


            if( $request->hasFile('photo')) {
                $file = $request->file('photo');
                $imageType = $file->getClientOriginalExtension();

                $image_resize = Image::make($file)->resize( null, 255, function ( $constraint ) {
                    $constraint->aspectRatio();
                })->encode( $imageType );
            }

            $this->saveLog(2, $enseignant, array(),$enseignant, true,"ENSEIGNANTS");
            return redirect()->route("enseignant");

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function show($enseignant)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Enseignant::where("id", "=", $enseignant)->first();
        $data2 = Matiere::whereNotIn("id", Enseignantmatiere::select("matiere_id")->where("enseignant_id","=", $enseignant)->get())->get();

        $this->saveLog(3, $enseignant, array(),$enseignant, true,"ENSEIGNANTS");
        return view("enseignants.read")->with("data", $data)->with("data2", $data2);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function edit($enseignant)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Enseignant::where("id", "=", $enseignant)->first();

        return view("enseignants.form")->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $enseig)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $validate = Validator::make($request->all(),[
            "firstname" => "required",
            "lastname" => "required",
            "sexe" => "required",
            "nationality" => "required",
            "phone" => "required",
            "specialite" => "required",
            "email" => "required",
        ]);


        if($validate->fails()){
            return redirect()->route("enseignantEdit")->withInput($request->all())->withErrors($validate->errors());
        }else{

            $enseignant = Enseignant::where("id", "=", $enseig)->first();

            $enseignant->lastname = $request->input("lastname");
            $enseignant->firstname = $request->input("firstname");
            $enseignant->sexe = $request->input("sexe");
            $enseignant->nationality = $request->input("nationality");
            $enseignant->phonenumber = $request->input("phone");
            $enseignant->diplome = $request->input("diplome");
            $enseignant->grade = $request->input("grade");
            $enseignant->specialite = $request->input("specialite");
            $enseignant->email = $request->input("email");
            $enseignant->update();

            if($request->hasFile("photo")){

                $valid = Validator::make($request->all(), [
                    "photo" => "required|mimes:jpg,bmp,png|max:2048"
                ]);
                if(!$valid->fails()){
                    $name = str_replace(" ", "", $request->input("lastname").$request->input("firstname"));
                    $filePath = $request->file('photo')->storeAs('uploads/enseignant/', $name."_issat.".$request->file("photo")->getClientOriginalExtension(), 'public');
                    $data = Enseignant::where("id","=",$enseig)->first();
                    $data->photo = '/storage/' . $filePath;
                    $data->update();
                }

            }
            $this->saveLog(4, $enseig, array(),$enseignant, true,"ENSEIGNANTS");

            return redirect()->route("enseignant")->with("success", "success");

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function destroy($enseignant)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Enseignant::where("id", "=", $enseignant)->first();
        $data->delete();
        $this->saveLog(5, $data, array(),array(), true,"ENSEIGNANTS");
        return redirect()->route("enseignant")->with("success", "success");
    }


    public function listOfTeacher($sort){

        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Enseignant::all()->sortBy(["lastname", "firstname"]);
        $data2 = Enseignant::all()->groupBy("grade");
        $data3 = Enseignant::all()->groupBy("specialite");
        $data4 = Enseignant::all();
        $data5 = Enseignant::all()->groupBy("nationality");

        $this->saveLog("IMPRESSION DE LA LISTE DES ENSEIGNANTS", $data, array(),array(), true,"ENSEIGNANTS");

        return view('pdf.listeenseignant')
            ->with('data', $data)
            ->with('data2', $data2)
            ->with('data3', $data3)
            ->with('data4', $data4)
            ->with('data5', $data5)
            ->with('by', $sort)
            ->with('count', 1);
    }

    public function disponibilite(Request $request){
        $validate = $request->validate([
            "start" => "required",
            "jours" => "required",
        ]);

        $disponibilite = new Disponibilite();
        $disponibilite->enseignant_id = $request->input("enseignant");
        $disponibilite->started = $request->input("start");
        $disponibilite->days = json_encode($request->input("jours"));
        $disponibilite->observation = $request->input("observation");
        $disponibilite->created_at = date("Y-m-d h:i:s");
        $disponibilite->save();

        $this->saveLog("ENREGISTREMENT DE LE DISPONIBILITE DE L'ENSEIGNANT", $disponibilite, array(),array(), true,"ENSEIGNANTS");
        return redirect()->route("enseignantShow", ["slug"=>$request->input("enseignant")]);
    }


    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="enseignant-list" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
