<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{


    public function lang(Request $request, $locale)
    {
        app()->setLocale($locale);
        Session::put("locale",$locale);

        if($request->ajax()){
            return response()->json(['status'=>'Ajax request']);
        }else{
            return redirect()->back();
        }

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
