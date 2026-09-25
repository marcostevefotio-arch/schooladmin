<?php

namespace App\Http\Controllers;

use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDFS;
use Illuminate\Support\Facades\View;

class BulletinController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

//    public function viewModel(){
//        return view("bulletin.layout");
//    }

    public function viewModel(){
        $filename = 'hello_world.pdf';

        $data = [
            'title' => 'Hello world!'
        ];

        $view = View::make('bulletin.layout', $data);
        $html = $view->render();

        $pdf = new TCPDF();

        $pdf::SetTitle('Hello World');
//        $pdf->AddPage();
//        $pdf::AddPage('L', 'A4');
        $pdf::AddPage('L', 'A4');
        $pdf::Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output(public_path($filename), 'I');
        $this->saveLog("IMPRESSION DE MODELE DE BULLETINS", array(), array(),array(), true,"NOTES");
        return response()->download(public_path($filename));
    }

//    public function viewModel(){
//        set_time_limit(30000);
////        $data = Inscription::where("id","=", $id)->first();
////        return view('modules.pdf.preinscription', compact('data'));
//
//
////        $pdf = PDFS::loadView('pdf.bulletin.contenu',  compact('data'));
//        $pdf = PDFS::loadView('bulletin.layout');
//        $pdf->setPaper('a4', "landscape");
//        $pdf->output();
//        $canvas = $pdf->getDomPDF()->getCanvas();
//        $height = $canvas->get_height();
//        $width = $canvas->get_width();
//        $canvas->set_opacity(.1,"Multiply");
//        $canvas->page_text($width/3, $height/2, 'ISSAT', null,
//            150, array(0,0,0),2,2,-30);
//        return $pdf->stream();
//    }

    public function right(){
        $user = auth()->user()->personnel->groupe->permission;
        $right = array();
        foreach ($user as $r){
            if($r->menu->code_menu=="etudiant-notes" && !in_array($r->titre_permission, $right)){
                array_push($right, $r->titre_permission);
            }
        }

        View::share('right', $right);

        return $right;
    }
}
