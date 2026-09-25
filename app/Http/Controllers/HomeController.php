<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        View::share('active', "home");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $logs = auth()->user()->personnel->groupe->id;
        if($logs==1){
            $historique = Historique::all()->sortByDesc("created_at");
        }else{
            $historique = Historique::where('user_id', '=', auth()->user()->id)->orderBy("created_at", "DESC")->limit(10)->get();
        }

        View::share('active', "home");
        return view('home')->with("logs", $historique);
    }


    public function maintenance()
    {
        return view('redirection.maintenance');
    }


    public function denied(){

    }


}
