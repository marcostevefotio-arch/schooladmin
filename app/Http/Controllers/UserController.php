<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Menu;
use App\Models\Parametre;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Image;

class UserController extends Controller
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

        $this->parent = "Gestion de la sécurité";
        $this->titles = "Utilisateurs";
        $user = User::all();
        $this->saveLog(1, array(), array(),$user, true,"User");
        return view("security.users.list")->with("users", $user);
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

        $personnel = Personnel::all();
        return view("security.users.form")->with("personnel", $personnel);
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
            "email"=>"required|email|unique:users",
            "employe"=>"required",
        ]);

        $parametre = Parametre::where("option", "=", "Mot de passe")->first();

        if(!empty($parametre)){
            $user = new User();
            $user->codeUser = Str::random(20);
            $user->personnel_id = $request->input("employe");
            $user->email = $request->input("email");
            $user->active = 0;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $users = User::find($user);
        $this->saveLog(3, $user, array(),$users, true,"User");
        return view("security.users.read")
            ->with("user", $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $users = User::find($user);
        $personnel = Personnel::all();
        return view("security.users.form")
            ->with("user", $users)
            ->with("personnel", $personnel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $users = User::find($user);
        $this->saveLog(4, $user, array(),$users, true,"User");

        $users->personnel_id = $request->input("employe");
        $users->email = $request->input("email");
        $users->active = 0;
        $users->update();

        Session::flash('message', 'Compte utilisateur mise à jour avec succès');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Succes');
        return redirect()->route("user");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        if(!in_array("delete", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $users = User::find($user);

        $this->saveLog(5, array(), $user,$users, true,"User");
        $users->historique()->delete();
        $users->delete();

        Session::flash('message', 'Un compte utilisateur supprimé');
        Session::flash('alert-class', 'alert-success');
        Session::flash('alert-title', 'Success');
        return redirect()->back();
    }

    public function activeAccount($user){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $users = User::find($user);

        $users->active = ($users->active==1)? 0 : 1;
        $users->save();


        if($users->active==1){
            $this->saveLog("Desactivation de compte", $user, array(),$users, true,"User");
        }else{
            $this->saveLog("Activation de compte", $user, array(),$users, true,"User");
        }

        return redirect()->back();
    }

    public function resetAccountPassword($user){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }

        $users = User::find($user);
        $parametre = Parametre::where("option", "=", "Mot de passe")->first();
        if(!empty($parametre)){
            $users->password = Hash::make($parametre->valeur);
            $users->save();
            $this->saveLog("Reinitialisation de mot de passe par defaut", $user, array(),$users, true,"User");

            Session::flash('message', 'Mot de passe reinitialisé. Utilisez le mot de passe par defaut pour vous connecter');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'success');
        }else{
            $this->saveLog("Reinitialisation de mot de passe par defaut", $user, array(),$users, false,"User");

            Session::flash('message', 'Mot de passe par defaut non configuré');
            Session::flash('alert-class', 'alert-warning');
            Session::flash('alert-title', 'Attention');
        }


        $this->saveLog("Reinitialisation de mot de passe", $user, array(),$users, true,"User");
        return redirect()->back();
    }

    public function profile($user)
    {
        if(!in_array("read", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $data = User::find($user);
        $this->saveLog("Consultation du prodile", $user, array(),$data, true,"User");

        return view("securite.utilisateurs.profile")->with("data", $data);
    }

    public function changePassword($user){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }
        $data = User::find($user);
        return view("securite.utilisateurs.editpassword")->with("data", $data);
    }

    public function changePasswordUpdate(Request $request, $u){
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        $user = User::find($u);
        $oldpassword = $request->input("oldpassword");

        if (!Hash::check($oldpassword, $user->password)) {
            $this->saveLog("Modification de mot de passe", $user, array(),$user, false,"User");
            return redirect()->route("passwordEdit", ["slug"=>$u])->withErrors( "Ancien mot de passe incorrect");
        }else{
            Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $newpassword = $request->input("password");

            $user->password = Hash::make($newpassword);
            $user->save();
            $this->saveLog("Modification de mot de passe", $user, array(),$user, true,"User");
            Session::flash('message', 'Mot de passe modifié avec succès');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succes');

            return redirect()->route("userProfile", ["slug"=>$u])->with("success", "Mot de passe modifié avec success");
        }
    }

    public function avatar(Request $request)
    {
        if(!in_array("update", $this->right())){
            Session::flash('message', 'Vous n\'avez pas accès aux fonctionalités de ce module');
            Session::flash('alert-class', 'alert-danger');
            Session::flash('alert-title', 'Echec');
            return redirect()->back();
        }


        try{
            $user = Auth::user();
            $old = $user;
            if( $request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $imageType = $file->getClientOriginalExtension();

                $image_resize = Image::make($file)->resize( null, 255, function ( $constraint ) {
                    $constraint->aspectRatio();
                })->encode( $imageType );
                $user->avatar = $image_resize;
                $user->avatarType = $imageType;
            }

            $user->save();
            $this->saveLog("Modification de la photo de profile", $old, array(),$user, true,"User");
            Session::flash('message', 'Photo de profile modifié avec succès');
            Session::flash('alert-class', 'alert-success');
            Session::flash('alert-title', 'Succes');
            return back();
        }
        catch(\Illuminate\Database\QueryException $ex){
            Session::put('failed', substr($ex->getMessage(),0, 90));
            return str_limit($ex->getMessage(), 90);
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
