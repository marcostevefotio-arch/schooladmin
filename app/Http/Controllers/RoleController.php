<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }


    public function index()
    {
        $data = Role::all();
        return view("modules/securite/groupe/list")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::all();
        return view("modules/securite/groupe/form")->with("modules", $modules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Validator::make($request->all(), [
            "titre"=>"required |unique:roles",
        ]);


        $role = Role::create([
            'titre_role' => $request->input('titre'),
            'description_role' => $request->input('description'),
        ]);

        if(!empty($role)){
            $permission = Permission::all();
            $permission_list = array();
            foreach ($permission as $p){
                if(key_exists("permission_".$p->id, $request->all())){
                    array_push($permission_list, $p->id);
                }
            }

            $role->permission()->attach($permission_list);
        }

        return redirect()->route("acces");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($role)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($role)
    {
        $roles = Role::find($role);
        $modules = Module::all();
        return view("modules/securite/groupe/form")->with("roles", $roles)->with("modules", $modules);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        Validator::make($request->all(), [
            "titre"=>"required |unique:roles",
        ]);


        $role = Role::find($role);

        $role->titre_role = $request->input('titre');
        $role->description_role = $request->input('description');

        $role->permission()->detach();

        $role->update();

        if(!empty($role)){
            $permission = Permission::all();
            $permission_list = array();
            foreach ($permission as $p){
                if(key_exists("permission_".$p->id, $request->all())){
                    array_push($permission_list, $p->id);
                }
            }

            $role->permission()->attach($permission_list);
        }

        return redirect()->route("acces");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($role)
    {
        $role = Role::find($role);
        $role->permission()->detach();
        $role->delete();

        $this->saveLog(5, $role, array(),array(), true,"SPECIALITES");

        return redirect()->route("acces");
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
