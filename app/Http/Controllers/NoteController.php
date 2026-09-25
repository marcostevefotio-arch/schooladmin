<?php

namespace App\Http\Controllers;

use App\Models\Anneeacademique;
use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\Menu;
use App\Models\Note;
use App\Models\Semestre;
use App\Models\Specialite;
use App\Models\Typeue;
use App\Models\Ue;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDFS;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware("auth");
        $this->parent = "Gestion des notes";
        $this->titles = "Notes";
        $menu = Menu::where("code_menu", "=", "homenote")->first();

        View::share('module', $menu);
        View::share('title', $this->titles);
        View::share('parent', $this->parent);
        View::share('option_route', route("note-list"));
        View::share('active', "homenote");
    }



    public function index()
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $ue = Ue::select("*")->orderBy("semestre_id", "DESC")->get();
        $this->saveLog(1, $ue, array(),array(), true,"NOTES");

        return view("noteevaluation.liste")->with("ue", $ue);
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

        $specialite = Specialite::all();
        $matiere = Matiere::all();
        $classe = Classe::all();
        $semestre = Semestre::all();
        $data = array("semestre"=>$semestre,"specialite"=>$specialite, "matiere"=>$matiere, "classe"=>$classe);
        return view("noteevaluation.form")->with("data", $data);
    }

    public function getMatieres(Request $request){
        $specialite_id = $request->input("specialite");
        $semestre_id = $request->input("semestre");
        $annee = Anneeacademique::where("active", "=", true)->first();

        $examen = $request->input("examen");
        $notes = Note::select("matiere_id")
            ->where("typeevaluation", "=", $examen)
            ->where("year", "=", date("Y"))
            ->get();

        $matieres = DB::table('specialites')
            ->join('ues', 'ues.specialite_id', '=', 'specialites.id')
            ->join('matieres', 'matieres.ue_id', '=', 'ues.id')
            ->select('matieres.id', 'matieres.libelleMatiere', 'ues.codeUE')
            ->where('specialites.id', '=', $specialite_id)
            ->whereNotIn('matieres.id', $notes)
            ->where('ues.semestre_id', '=', $semestre_id)
            ->get();

        $etudiants =  DB::table('etudiants')
            ->join('dossieretudiants', 'dossieretudiants.etudiant_id', '=', 'etudiants.id')
            ->join('inscriptions', 'inscriptions.dossieretudiant_id', '=', 'dossieretudiants.id')
            ->join('choices', 'choices.inscription_id', '=', 'inscriptions.id')
            ->join('specialites', 'specialites.id', '=', 'choices.specialite_id')
            ->select('dossieretudiants.matriculeDossier', 'etudiants.lastname', 'etudiants.firstname','etudiants.id as etID','inscriptions.id')
            ->where('choices.etat', '=', 1)
            ->where('specialites.id', '=', $specialite_id)
            ->where('inscriptions.anneeacademique_id', '=', $annee->id)
            ->get();


        return response()->json([$matieres, $etudiants]);
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

        $semestre = $request->input("semestre");
        $evaluation = $request->input("evaluation");
        $matiere = $request->input("matiere");
        $specialite_id = $request->input("specialite");
        $annee = Anneeacademique::where("active", "=", true)->first();

        $etudiants =  DB::table('etudiants')
            ->join('dossieretudiants', 'dossieretudiants.etudiant_id', '=', 'etudiants.id')
            ->join('inscriptions', 'inscriptions.dossieretudiant_id', '=', 'dossieretudiants.id')
            ->join('choices', 'choices.inscription_id', '=', 'inscriptions.id')
            ->join('specialites', 'specialites.id', '=', 'choices.specialite_id')
            ->select('dossieretudiants.matriculeDossier', 'etudiants.lastname', 'etudiants.firstname','etudiants.id as etID','inscriptions.id as inscID')
            ->where('choices.etat', '=', 1)
            ->where('specialites.id', '=', $specialite_id)
            ->where('inscriptions.anneeacademique_id', '=', $annee->id)
            ->get();

        foreach ($etudiants as $et){
            $elem = $request->input($et->inscID);
            if(isset($elem)){
                $existnote = Note::where("inscription_id", "=", $et->inscID)->where("typeevaluation", "=", $evaluation)->where("matiere_id", "=", $matiere)->where("year", $annee->numeroAnnee)->first();
                if(empty($existnote)){
                    $note = new Note();
                    $note->inscription_id = $et->inscID;
                    $note->matiere_id = $matiere;
                    $note->semestre_id = $semestre;
                    $note->typeevaluation = $evaluation;
                    $note->codeNote = Str::random(20);
                    $note->moyenne = floatval($elem);
                    $note->year = date("Y");
                    $note->created_at = now();
                    $note->save();

//                    var_dump($note);
                }else{
                    $existnote->moyenne = floatval($elem);
                    $existnote->updated_at = now();
                    $existnote->update();
//                    var_dump($existnote);
                }
            }
        }

//        echo json_encode($request->all());

        $this->saveLog(2, array(), array(),array(), true,"NOTES");

        Session::flash('message', 'Note enregistré avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($note)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $this->saveLog(3, $note, array(),array(), true,"NOTES");

        $notes = Note::where("id", "=", $note)->first();

        return view("noteevaluation.read")->with("note", $notes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
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
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $note)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $notes = Note::where("id", "=", $note)->first();
        $notes->moyenne = $request->input("moyenne");
        $notes->update();
        Session::flash('message', 'Note modifié avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succès');
        $this->saveLog(5, $note, array(),$notes, true,"NOTES");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $this->saveLog(5, $note, array(),array(), true,"NOTES");
    }


    public function bulletin(Request $request){
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $specialite = $request->input("specialite");

        $ue_tmp = Ue::select("ues.*", "ues.id as idue", "matieres.*", "matieres.id as idm")
            ->where("specialite_id", "=", $specialite)
            ->join("matieres", "matieres.ue_id", "=", "ues.id")
            ->where("specialite_id", "=", $specialite)
            ->get();
        $ue = collect($ue_tmp)->groupBy("codeUE")->map(function ($item) {
            return array_merge($item->toArray());
        });

        $typeue = Typeue::all();

        $notes = Note::where('year', '=', date("Y"))->get();

        $etudiants =  Etudiant::select("etudiants.*","etudiants.id as etID", "inscriptions.*", "specialites.*", "filieres.*")
            ->join("dossieretudiants", "dossieretudiants.etudiant_id", "=","etudiants.id")
            ->join("inscriptions", "inscriptions.dossieretudiant_id", "=","dossieretudiants.id")
            ->join("choices", "choices.inscription_id", "=","inscriptions.id")
            ->join("specialites", "choices.specialite_id", "=","specialites.id")
            ->join("filieres", "specialites.filiere_id", "=","filieres.id")
            ->where("specialites.id", "=", $specialite)
            ->orderBy("etudiants.lastname", "ASC")
            ->get();

//        $this->authorize('view', $ue);

        $pdf = PDFS::loadView('bulletin.layout', array("ue"=>$ue,"typeue"=>$typeue, "etudiants"=>$etudiants, "notes"=>$notes));
        $pdf->setPaper('a4', "landscape");
        $pdf->output();
//        $canvas = $pdf->getDomPDF()->getCanvas();
//        $height = $canvas->get_height();
//        $width = $canvas->get_width();
//        $canvas->set_opacity(.05,"Multiply");
//        $canvas->page_text($width/3, $height/2, 'ISSAT', null,100, array(0,0,0),2,2,-30);
        return $pdf->stream();
    }

    public function notesOptions(){
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $data = Filiere::all();
        $data2 = Semestre::all();
        return view("noteevaluation.options")->with("filiere", $data)->with("semestre", $data2);
    }

    public function notesEtudiant($id){
        $etudiant = Etudiant::where("id", "=", $id)->first();
        $notes = array();

        foreach($etudiant->notes as $i=>$n){
            $notes[$i] = array();
        }

        $this->saveLog(3, $etudiant, array(),$etudiant->notes, true,"NOTES");
    }

    public function pvSemestre(){
        $filiere = Filiere::all();
        $semestre = Semestre::all();
        return view("noteevaluation.options")->with("filiere", $filiere)->with("semestre", $semestre);
    }

//    public function pv(Request $request){
//        ini_set('max_execution_time', -1);
////        ini_set('memory_limit', '512MB');
//
//        $specialite_id = $request->input("specialite");
//        $semestre = $request->input("semestre");
//
//        if(!in_array("print", $this->right())){
//            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
//            Session::flash('alert-class', 'alert-danger');
//            Session::flash('alert-title', 'Echec');
//            return redirect()->back();
//        }
//
//        if(!is_null($specialite_id)){
//            $specialite = Specialite::where("id","=", $specialite_id)->get();
//        }else{
//            $specialite = Specialite::all();
//        }
//
//
//        if(!is_null($semestre)){
//            $s = Semestre::where("id","=", $semestre)->get();
//        }else{
//            $s = Semestre::all();
//        }
//
//        $data = [
//            'specialite' => $specialite,
//            'semestres' => $s,
//        ];
//
//
//        $pdf = PDFS::loadView('pdf.pv',  $data);
//        $pdf->setPaper('a3', 'landscape');
//        $pdf->output();
//
////        $this->saveLog("Impression des PV", $specialite, array(),array(), true,"NOTES");
//        return $pdf->stream();
//    }

    public function pv(Request $request){
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512MB');

        $specialite_id = $request->input("specialite");
        $semestre = $request->input("semestre");


        if(!is_null($semestre)){
            $s = Semestre::where("id","=", $semestre)->get();
        }else{
            $s = Semestre::all();
        }

        if(!is_null($specialite_id)){
            $pv = $this->ListeNotesEtudiants($specialite_id);
            if(count($s)==1){
                $ues = Ue::where("specialite_id", "=", $specialite_id)->where("semestre_id", "=", $s[0]->id)->get();
            }else{
                $ues = Ue::where("specialite_id", "=", $specialite_id)->get();
            }
        }else{
            $pv = array();
            $ues = array();
        }

        $format = $request->input("format");

        if($format == "a4"){
            $data = [
                'pvs' => $pv,
                'semestre' => $s,
                'ues' => $ues,
                'font' => array(
                    "title-font" => 14,
                    "content-font" => 14,
                )
            ];
            $pdf = PDFS::loadView('pdf.pvA4',  $data);


            $pdf->setPaper('a4', 'landscape');
            $pdf->output();

            $this->saveLog("Impression des PV", array(), array(),array(), true,"NOTES");
            return $pdf->stream();
        }else if($format == "a2"){
            $data = [
                'pvs' => $pv,
                'semestre' => $s,
                'ues' => $ues,
                'font' => array(
                    "title-font" => 14,
                    "content-font" => 14,
                )
            ];
            $pdf = PDFS::loadView('pdf.pvA2',  $data);


            $pdf->setPaper('a2', 'landscape');
            $pdf->output();

            $this->saveLog("Impression des PV", array(), array(),array(), true,"NOTES");
            return $pdf->stream();
        }else{
            $data = [
                'pvs' => $pv,
                'semestre' => $s,
                'ues' => $ues,
                'font' => array(
                    "title-font" => 12,
                    "content-font" => 12,
                )
            ];
            $pdf = PDFS::loadView('pdf.pvA3',  $data);


            $pdf->setPaper('a3', 'landscape');
            $pdf->output();

            $this->saveLog("Impression des PV", array(), array(),array(), true,"NOTES");
            return $pdf->stream();
        }
    }


    public function releveSemestre(){
        $filiere = Filiere::all();
        $semestre = Semestre::all();
        return view("noteevaluation.releve")->with("filiere", $filiere)->with("semestre", $semestre);
    }

    public function releve(Request $request){
        if(!in_array("print", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        ini_set('max_execution_time', -1);

        $specialite_id = $request->input("specialite");
        $semestre = $request->input("semestre");

        if(!is_null($specialite_id)){
            $specialite = Specialite::where("id","=", $specialite_id)->get();
        }else{
            $specialite = Specialite::all();
        }


        if(!is_null($semestre)){
            $s = Semestre::where("id","=", $semestre)->get();
        }else{
            $s = Semestre::all();
        }

        $data = [
            'specialite' => $specialite,
            'semestres' => $s,
        ];


        $pdf = PDFS::loadView('pdf.bulletins.contenu',  $data);
        $pdf->setPaper('a4');
        $pdf->output();

//        $this->saveLog("Impression des PV", $specialite, array(),array(), true,"NOTES");
        return $pdf->stream();
    }

    public function ListeNotesEtudiants($specialite){
        $annee = Anneeacademique::where("active", "=", true)->first();

        $inscription = Inscription::where("choices.etat", "=", 1)
            ->where("choices.specialite_id", "=", $specialite)
            ->where("inscriptions.anneeacademique_id", "=", $annee->id)
            ->join('choices', 'inscriptions.id', '=', 'choices.inscription_id')
            ->join('specialites', 'specialites.id', '=', 'choices.specialite_id')
            ->join('anneeacademiques', 'inscriptions.anneeacademique_id', '=', 'anneeacademiques.id')
            ->join('dossieretudiants', 'inscriptions.dossieretudiant_id', '=', 'dossieretudiants.id')
            ->join('etudiants', 'dossieretudiants.etudiant_id', '=', 'etudiants.id')
            ->orderBy("firstname")
            ->get();

//        $etudiant = Etudiant::where("choices.etat", "=", 1)
//            ->where("choices.specialite_id", "=", $specialite)
//            ->where("inscriptions.anneeacademique_id", "=", $annee->id)
//            ->join('dossieretudiants', 'dossieretudiants.etudiant_id', '=', 'etudiants.id')
//            ->join('inscriptions', 'inscriptions.dossieretudiant_id', '=', 'dossieretudiants.id')
//            ->join('choices', 'inscriptions.id', '=', 'choices.inscription_id')
//            ->join('specialites', 'specialites.id', '=', 'choices.specialite_id')
//            ->orderBy("lastname")
//            ->get();

//        return $etudiant;
        return $inscription;
    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="note-list" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
