<?php

namespace App\Http\Controllers;

use App\Models\Anneeacademique;
use App\Models\Antecedant;
use App\Models\Choice;
use App\Models\Cycle;
use App\Models\Dossieretudiant;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Frai;
use App\Models\Inscription;
use App\Models\Level;
use App\Models\Menu;
use App\Models\Parcour;
use App\Models\Perent;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDFS;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des inscriptions";
        $this->titles = "Liste des inscriptions";
        $menu = Menu::where("code_menu", "=", "homeinscription")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("homeinscription"));
        View::share('active', "homeinscription");
    }



    public function index($year = null)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

//        var_dump($year);
        if(is_null($year)){
            $annee = Anneeacademique::where("active", "=", true)->first();
            if(!empty($annee)){
                $data = Inscription::where("anneeacademique_id", "=", $annee->id)->get();
            }else{
                $data = array();
            }
        }else{
            $annee = Anneeacademique::where("id", "=", $year)->first();
            $data = Inscription::where("anneeacademique_id", "=", $annee->id)->get();
        }
        $allAnnee = Anneeacademique::all();
        $this->saveLog(1, $data, array(),array(), true,"INSCRIPTIONS");
        return view("inscriptions.list")->with("data", $data)->with("annee", $allAnnee)->with("activeAnnee", !empty($annee)? $annee->numeroAnnee : "");
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
        $levels = Level::all();
        $cycle = Cycle::all();
        $annee = Anneeacademique::where("active", "=", true)->first();
        $formations = Filiere::all()->sortBy("libelleFiliere");

        if(empty($annee)){
            $max = "";
        }else{
            $max = Inscription::where("anneeacademique_id", "=", $annee->id)->max("id");
        }


        $this->titles = "Inscriptions";
        View::share('title', $this->titles);
        return view("inscriptions.form")
            ->with("filiere", $formations)
            ->with("max", $max+1)
            ->with("cycle", $cycle)
            ->with("level", $levels)
            ->with("year", $annee);
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
            "cycle" => "required",
            "formation1" => "required",
            "speciality1" => "required",
            "formation2" => "required",
            "speciality2" => "required",
            "formation3" => "required",
            "speciality3" => "required",
            "start" => "required",
            "depositeDate" => "required|date",
            "firstname" => "required",
            "lastname" => "required",
            "sexe" => "required",
            "level" => "required",
            "birthday" => "required|date",
            "birthplace" => "required",
            "nationality" => "required",
            "region" => "required",
            "phone" => "required",
            "email" => "required|unique:etudiants",
            "language" => "required",
            "diploma" => "required",
            "serie" => "required",
            "yearobtain" => "required",
            "countryobtain" => "required",
            "school" => "required",
            "emergencepersonne" => "required",
            "emergencecontact" => "required",
        ]);

        if($validate->fails()){
            return redirect()->route("inscriptionForm")->with("error", $validate->errors());
        }else {
            $cycle = Cycle::where("id", "=", $request->input("cycle"))->first();
            $level = Level::where("id", "=", $request->input("level"))->first();
            $annee = Anneeacademique::where("numeroAnnee", "=", $request->input("start"))->first();
            $parent = new Perent();
            $etudiants = new Etudiant();
            $dossier = new Dossieretudiant();
            $inscription = new Inscription();
            $parcours = new Parcour();

//          parents insert
            if(!empty($request->input("emergencepersonne")) && $request->input("emergencecontact")){
                $parent->codeParent = Str::random(20);
                $parent->fathername = $request->input("fathername");
                $parent->fatherprofession = $request->input("fatherprofession");
                $parent->fathercontact = $request->input("fathercontact");
                $parent->mothername = $request->input("mothername");
                $parent->motherprofession = $request->input("motherprofession");
                $parent->mothercontact = $request->input("mothercontact");
                $parent->emergencyname = $request->input("emergencepersonne");
                $parent->emergencycontact = $request->input("emergencecontact");
                $parent->save();
            }


//          etudiants insertion
            $etudiants->codeEtudiant = Str::random(20);
            $etudiants->lastname = $request->input("lastname");
            $etudiants->firstname = $request->input("firstname");
            $etudiants->sexe = $request->input("sexe");
            $etudiants->birthday = $request->input("birthday");
            $etudiants->birthplace = $request->input("birthplace");
            $etudiants->nationality = $request->input("nationality");
            $etudiants->region = $request->input("region");
            $etudiants->phonenumber = $request->input("phone");
            $etudiants->email = $request->input("email");
            $etudiants->language = $request->input("language");
            $etudiants->sport = $request->input("bestsport");
            $etudiants->leisure = $request->input("leisure");
            $etudiants->parents()->associate($parent);
            $etudiants->save();


            $dossier = new Dossieretudiant();
            $dossier->codeDossier = Str::random(20);
            $dossier->numeroDossier = $request->input("dossier");
            $dossier->matriculeDossier = $request->input("matricule");
            $dossier->cycle()->associate($cycle);
            $dossier->etudiant()->associate($etudiants);
            $dossier->anneeacademique()->associate($annee);
            $dossier->save();

            $inscription->codeInscription = Str::random(20);
            $inscription->dateInscription = $request->input("depositeDate");
            $inscription->divers = $request->input("divers");
            $inscription->anneacademique()->associate($annee);
            $inscription->level()->associate($level);
            $inscription->dossier()->associate($dossier);
            $inscription->save();



//          parcours insertion
            $parcours->admissiondiploma = $request->input("diploma");
            $parcours->codeParcours = Str::random(20);
            $parcours->option = $request->input("serie");
            $parcours->schoolyear = $request->input("yearobtain");
            $parcours->diplomacountry = $request->input("countryobtain");
            $parcours->schoolattended = $request->input("school");
            $parcours->dossier()->associate($dossier);
            $parcours->save();



            foreach(range(1,3) as $i){
                $specialite = Specialite::where('id', '=', $request->input("speciality".$i))->first();
                $choix = new Choice();
                $choix->specialite()->associate($specialite);
                $choix->inscription()->associate($inscription);
                $choix->save();
            }


            for($i=0; $i<10; $i++){
                if(isset($_POST["maladie".$i])){
                    $antecedant = new Antecedant();
                    $antecedant->etudiant_id = $etudiants->id;
                    $antecedant->codeAntecedants = Str::random(20);
                    $antecedant->maladie = $request->input("maladie".$i);
                    $antecedant->dateconsultation = $request->input("dateConsultation".$i);
                    $antecedant->etat = $request->input("etat".$i);
                    $antecedant->save();
                }
            };




            if($request->hasFile("photo")){

                $valid = Validator::make($request->all(), [
                    "photo" => "required|mimes:jpg,bmp,png|max:2048"
                ]);
                if(!$valid->fails()){
                    $filePath = $request->file('photo')->storeAs('uploads/etudiants/'.$request->input("cycle")."/".$request->input("speciality"), $inscription."-".$etudiants->id."_issat.".$request->file("photo")->getClientOriginalExtension(), 'public');
                    $data = Etudiant::where("id","=",$etudiants->id)->first();
                    $data->photo = '/storage/' . $filePath;
                    $data->update();
                }

            }

            $this->saveLog(2, array(), array(),array(), true,"INSCRIPTIONS");
            Session::flash('message', 'L\'inscription a été enregistré avec succès');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succès');

            return redirect()->route("inscription");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function show($inscript)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Inscription::find($inscript);

        $this->saveLog(3, $inscript, array(),array(), true,"INSCRIPTIONS");
        return view("inscriptions.read")->with("data", $data)->with("offline", true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function edit($inscription)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Inscription::find($inscription);
        $levels = Level::all();
        $cycle = Cycle::all();
        $annee = Anneeacademique::where("active", "=", true)->first();
        $formations = Filiere::all()->sortBy("libelleFiliere");


        return view("inscriptions.form")
            ->with("data", $data)
            ->with("filiere", $formations)
            ->with("max", $data->id)
            ->with("cycle", $cycle)
            ->with("level", $levels)
            ->with("year", $annee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $inscript)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $validate = Validator::make($request->all(),[
            "formation1" => "required",
            "speciality1" => "required",
            "formation2" => "required",
            "speciality2" => "required",
            "formation3" => "required",
            "speciality3" => "required",
            "start" => "required",
            "depositeDate" => "required|date",
            "firstname" => "required",
            "lastname" => "required",
            "sexe" => "required",
            "level" => "required",
            "birthday" => "required",
            "birthplace" => "required",
            "nationality" => "required",
            "region" => "required",
            "phone" => "required",
            "email" => "required",
            "language" => "required",
            "diploma" => "required",
            "serie" => "required",
            "yearobtain" => "required",
            "countryobtain" => "required",
            "school" => "required",
        ]);

        if($validate->fails()){
            return redirect()->route("inscriptionForm")->with("error", $validate->errors());
        }else {
            $inscription = Inscription::where("id", "=", $inscript)->first();
            $etudiants = Etudiant::where("id", "=", $inscription->dossier->etudiant_id)->first();
            $parent = Perent::where("id", "=", $inscription->dossier->etudiant->parent_id)->first();
            $parcours = Parcour::where("id", "=", $inscription->dossier->parcours[0]->id)->first();
            $cycle = Cycle::where("id", "=", $request->input("cycle"))->first();
            $level = Level::where("id", "=", $request->input("level"))->first();
            $annee = Anneeacademique::where("numeroAnnee", "=", $request->input("start"))->first();



//          parents insert
            if (!empty($request->input("emergencepersonne")) && $request->input("emergencepersonne")) {
                //          parents insert
                $parent->fathername = $request->input("fathername");
                $parent->fatherprofession = $request->input("fatherprofession");
                $parent->fathercontact = $request->input("fathercontact");
                $parent->mothername = $request->input("mothername");
                $parent->motherprofession = $request->input("motherprofession");
                $parent->mothercontact = $request->input("mothercontact");
                $parent->emergencyname = $request->input("emergencepersonne");
                $parent->emergencycontact = $request->input("emergencecontact");
                $parent->update();
            }


//          etudiants insertion
            $etudiants->parent_id = $parent->id;
            $etudiants->lastname = $request->input("lastname");
            $etudiants->firstname = $request->input("firstname");
            $etudiants->sexe = $request->input("sexe");
            $etudiants->birthday = $request->input("birthday");
            $etudiants->birthplace = $request->input("birthplace");
            $etudiants->nationality = $request->input("nationality");
            $etudiants->region = $request->input("region");
            $etudiants->phonenumber = $request->input("phone");
            $etudiants->email = $request->input("email");
            $etudiants->language = $request->input("language");
            $etudiants->sport = $request->input("bestsport");
            $etudiants->leisure = $request->input("leisure");
            $etudiants->update();


//          parcours insertion
            $parcours->admissiondiploma = $request->input("diploma");
            $parcours->option = $request->input("serie");
            $parcours->schoolyear = $request->input("yearobtain");
            $parcours->diplomacountry = $request->input("countryobtain");
            $parcours->schoolattended = $request->input("school");
            $parcours->update();



//          inscription insert
            $inscription->dateInscription = $request->input("depositeDate");
            $inscription->divers = $request->input("divers");
            $inscription->anneacademique()->associate($annee);
            $inscription->level()->associate($level);
            $inscription->update();


            $ch = Choice::where("inscription_id", "=", $inscription->id)->get();

            foreach($ch as $c){
                $c->delete();
            }

            foreach(range(1,3) as $i){
                $specialite = Specialite::where('id', '=', $request->input("speciality".$i))->first();
                $choix = new Choice();
                $choix->specialite()->associate($specialite);
                $choix->inscription()->associate($inscription);
                $choix->save();
            }







            $this->saveLog(4, $inscription, array(),array(), true,"INSCRIPTIONS");
            Session::flash('message', 'L\'inscription a été mise à jour avec succès');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succès');
            return redirect()->route("inscription");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function destroy($inscript)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $inscription = Inscription::where("id", "=", $inscript)->first();
        $etudiants = Etudiant::where("id", "=", $inscription->etudiant_id)->first();
        $parent = Perent::where("id", "=", $inscription->etudiant->parent_id)->first();
        $parcours = Parcour::where("id", "=", $inscription->parcour_id)->first();


        foreach ($inscription->choice as $c){
            Choice::destroy($c->id);
        }

        foreach ($inscription->etudiant->antecedants as $a){
            Antecedant::destroy($a->id);
        }

        foreach ($inscription->frais as $f){
            Frai::destroy($f->id);
        }

        $inscription->delete();
        $etudiants->delete();
        $parent->delete();
        $parcours->delete();


        $this->saveLog(5, $inscription, array(),array(), true,"INSCRIPTIONS");
        Session::flash('message', 'L\'inscription a été supprimé avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
        return redirect()->route("inscription");
    }


    public function test(){
        $etudiants = new Etudiant();
        $etudiants->parent_id  = 1;
        $etudiants->lastname  = "Marco";
        $etudiants->firstname  = "Steve";
        $etudiants->birthday  = "2021-10-6";
        $etudiants->birthplace  = "Dschang";
        $etudiants->nationality  = "Cameroon";
        $etudiants->region  = "West";
        $etudiants->phonenumber  = "672228234";
        $etudiants->email  = "toofisteve@mail.com";
        $etudiants->language  = "Francais";
        $etudiants->sport  = "Basketball";
        $etudiants->leisure  = "Bricolage";

        echo json_encode($etudiants->save());
    }


    public function printFile($id=""){
        ini_set('max_execution_time', -1);
        ini_set("memory_limit","512M");
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        if(!empty($id)){
            $data = Inscription::where("id","=", $id)->get();
        }else{
            $data = Inscription::all();
        }

        $pdf = PDFS::loadView('pdf.insc-pdf',  compact('data'));
        $pdf->setPaper('L');
//        $pdf->output();

        $this->saveLog("IMPRESSION DES FICHES", $id, array(),array(), true,"INSCRIPTIONS");

        return $pdf->stream();
    }


    public function validerChoix($choix){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $choix = Choice::where("id", "=", $choix)->first();

        $reset = Choice::where("inscription_id", "=", $choix->inscription_id)->get();
        $specialite = "";
        foreach ($reset as $r){
            if($r->etat==1){
                $specialite = $r->specialite->codeSpecialite;
            }
            $r->etat = 0;
            $r->update();
        }

        $choix->etat = 1;
        $choix->update();

        $this->saveLog("Validation du choix", $choix, array(),$reset, true,"INSCRIPTIONS");
        Session::flash('message', 'Choix de spécialité modifié pour l\'étudiant selectioné');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
        return redirect()->back();
    }


    public function updateFrais(Request $request, $id){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $frais = Frai::find($id);
        $frais->deuxieme = (($frais->deuxieme + $request->input("premiere")) >= $frais->total)? $frais->total :  ($frais->deuxieme + $request->input("premiere"));
        $frais->etat = ($frais->deuxieme >= $frais->total)? true : false;
        $frais->update();

        $this->saveLog(4, $frais, array(),array(), true,"FRAIS");
        return redirect()->route("inscriptionShow", ["slug"=>$frais->inscription->id])->with("success", "Paiement enregistré");
    }


//    public function states($year="2022"){
//        if(!in_array("read", $this->right())){
//            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
//            Session::flash('alert-class', 'alert-danger');
//            Session::flash('alert-title', 'Echec');
//            return redirect()->back();
//        }
//
//        $filiere = Filiere::all();
//
//        $annee = Anneeacademique::where("active","=", true)->first();
//        $inscriptions = Inscription::where("anneeacademique_id","=", $annee->id)->get();
//        $inscriptionsAll = Inscription::all();
//        $insciptionChoix = $this->inscriptionChoix($inscriptions);
//        $inscriptionsFiliere = $this->inscriptionFiliere($inscriptions);
//        $inscriptionsSpecialite = $this->inscriptionSpecialite($inscriptions);
//        $inscriptionCycle = $this->inscriptionCycle($inscriptions);
//        $inscriptionSexe = $this->inscriptionSexe($inscriptions);
//        $inscriptionNationalite = $this->inscriptionNationalite($inscriptions);
//        $inscriptionAnnee = $this->inscriptionAnnee($inscriptions);
//
//
//        $data = array(
//            "inscriptionAll"=>$inscriptionsAll,
//            "inscription"=>$inscriptions,
//            "choix"=>$insciptionChoix,
//            "filiere"=>$inscriptionsFiliere,
//            "specialite"=>$inscriptionsSpecialite,
//            "cycle"=>$inscriptionCycle,
//            "sexe"=>$inscriptionSexe,
//            "nationalite"=>$inscriptionNationalite,
//            "anneeInscriptions"=>$inscriptionAnnee,
//            "annee"=>Anneeacademique::all(),
//        );
//
//        $this->titles = "Etat des inscriptions";
//        View::share('title', $this->titles);
//        View::share('option_route', route("inscription-etat"));
//        return view("inscriptions.etats")->with("filiere", $filiere)->with("state", $data);
//    }

    public function states(){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $filiere = Filiere::all();


        $data = array(
            "totalFiliere"=> Filiere::all()->count(),
            "totalSpecialite"=> Specialite::all()->count(),
            "etudiants"=> Etudiant::all()->count(),
            "etudiantsF"=> Etudiant::where("sexe", "=", "FEMININ")->count(),
            "etudiantsG"=> Etudiant::where("sexe", "=", "MASCULIN")->count(),
            "annee"=> Anneeacademique::all(),
            "inscription"=> Inscription::all(),
        );

        $this->titles = "Etat des inscriptions";
        View::share('title', $this->titles);
        View::share('option_route', route("inscription-etat"));
        return view("inscriptions.etats")->with("filiere", $filiere)->with("state", $data);
    }

    public function inscriptionChoix($data){
        $inscriptions = array();
        foreach ($data as $d){
            foreach ($d->choice as $c){
                if($c->etat==1){
                    array_push($inscriptions, $d);
                    break;
                }
            }
        }

        return $inscriptions;
    }

    public function inscriptionFiliere($data){
        $inscriptions = array();
        foreach ($data as $d){
            foreach ($d->choice as $c){
                if($c->etat==1){
                    if(isset($inscriptions[$c->specialite->filiere->codeFiliere])){
                        array_push($inscriptions[$c->specialite->filiere->codeFiliere], $d);
                    }else{
                        array_push($inscriptions, array($c->specialite->filiere->codeFiliere=>$d));
                    }

                    break;
                }
            }
        }

        return $inscriptions;
    }

    public function inscriptionSpecialite($data){
        $inscriptions = array();
        foreach ($data as $d){
            foreach ($d->choice as $c){
                if($c->etat==1){
                    if(isset($inscriptions[$c->specialite->codeSpecialite])){
                        array_push($inscriptions[$c->specialite->codeSpecialite], $d);
                    }else{
                        array_push($inscriptions, array($c->specialite->codeSpecialite=>$d));
                    }

                    break;
                }
            }
        }

        return $inscriptions;
    }

    public function inscriptionCycle($data){
        $inscriptions = array();
        foreach ($data as $d){
            foreach ($d->choice as $c){
                if($c->etat==1){
                    if(isset($inscriptions[$d->cycle])){
                        array_push($inscriptions[$d->cycle], $d);
                    }else{
                        array_push($inscriptions, array($d->cycle=>$d));
                    }
                    break;
                }
            }
        }

        return $inscriptions;
    }

    public function inscriptionSexe($data){
        $inscriptions = array();
        foreach ($data as $d){
            foreach ($d->choice as $c){
                if($c->etat==1){
                    if(array_key_exists($d->dossier->etudiant->sexe, $inscriptions)){
                        array_push($inscriptions[$d->dossier->etudiant->sexe], $d);
                    }else{
                        $inscriptions[$d->dossier->etudiant->sexe] = array($d);
                    }
                    break;
                }
            }
        }
        return $inscriptions;
    }

    public function inscriptionNationalite($data){
        $inscriptions = array();
        foreach ($data as $d){
            foreach ($d->choice as $c){
                if($c->etat==1){
                    if(isset($inscriptions[$d->dossier->etudiant->nationalite])){
                        array_push($inscriptions[$d->dossier->etudiant->nationalite], $d);
                    }else{
                        array_push($inscriptions, array($d->dossier->etudiant->nationalite=>$d));
                    }

                    break;
                }
            }
        }

        return $inscriptions;
    }

    public function inscriptionAnnee($data){
        $inscriptions = array();
        foreach ($data as $d){
            foreach ($d->choice as $c){
                if($c->etat==1){
                    if(isset($inscriptions[$d->year])){
                        array_push($inscriptions[$d->year], $d);
                    }else{
                        array_push($inscriptions, array($d->year=>$d));
                    }

                    break;
                }
            }
        }

        return $inscriptions;
    }

    public function allEffectifFilieres(Request $request){
        $effectifsFilieres = Filiere::select('count(inscriptions.id) as effectifs', 'filieres.*',  'etat')
            ->leftJoin('specialites', 'specialites.filiere_id', '=', 'filieres.id')
            ->leftJoin('choices', 'specialites.id', '=', 'choices.specialite_id')
            ->leftJoin('inscriptions', 'inscriptions.id', '=', 'choices.inscription_id')
            ->groupBy('filieres.id', 'etat')
            ->havingRaw("etat = 1")
            ->get();

        $effectifsSpecialite = DB::table('specialites')
            ->selectRaw('count(inscriptions.id) as effectifs, specialites.*, etat')
            ->leftJoin('choices', 'specialites.id', '=', 'choices.specialite_id')
            ->leftJoin('inscriptions', 'inscriptions.id', '=', 'choices.inscription_id')
            ->groupBy('specialites.id', 'etat')
            ->havingRaw("etat = 1")
            ->get();



        return response()->json([$effectifsFilieres, $effectifsSpecialite]);
    }

    public function effectifs(Request $request){
        $annee = $request->input("annee");
        $effectifs = DB::table('specialites')
            ->selectRaw('count(inscriptions.id) as effectifs, specialites.id, specialites.libelleSpecialite, specialites.codeSpecialite, choices.etat, inscriptions.anneeacademique_id')
            ->leftJoin('choices', 'specialites.id', '=', 'choices.specialite_id')
            ->leftJoin('inscriptions', 'inscriptions.id', '=', 'choices.inscription_id')
            ->groupBy('specialites.id', 'choices.etat', 'inscriptions.anneeacademique_id')
            ->havingRaw("etat = 1")
            ->having("inscriptions.anneeacademique_id", "=", $annee)
            ->get();
        $specialite = DB::table('specialites')
            ->selectRaw('count(inscriptions.id) as effectifs, specialites.id, specialites.libelleSpecialite, specialites.codeSpecialite, anneeacademique_id')
            ->leftJoin('choices', 'specialites.id', '=', 'choices.specialite_id')
            ->leftJoin('inscriptions', 'inscriptions.id', '=', 'choices.inscription_id')
            ->groupBy('specialites.id', 'inscriptions.anneeacademique_id')
            ->having("inscriptions.anneeacademique_id", "=", $annee)
            ->get();

        return response()->json([$effectifs, $specialite]);
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="inscriptions-list" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
