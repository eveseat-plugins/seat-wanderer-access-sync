<?php

namespace RecursiveTree\Seat\WandererAccessSync\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveTree\Seat\WandererAccessSync\Models\WandererAccessListInstance;
use RecursiveTree\Seat\WandererAccessSync\Models\WandererAccessListRole;
use Seat\Web\Http\Controllers\Controller;
use Seat\Web\Models\Acl\Role;

class SettingsController extends Controller
{
    public function list()
    {
        $roles = WandererAccessListRole::all();
        $seat_roles = Role::all();
        $wanderer_access_lists = WandererAccessListInstance::all();

        return view('wanderer-access-sync::list', compact('roles', 'seat_roles','wanderer_access_lists'));
    }

    public function createMapping(Request $request)
    {
        $request->validate([
            'role' => 'required|integer',
            'acl' => 'required|integer',
        ]);

        if(!WandererAccessListInstance::find($request->acl)) {
            return redirect()->back()->with('error','access list doesn\'t exist');
        }

        $role = new WandererAccessListRole();
        $role->role_id = $request->role;
        $role->wanderer_instance_id = $request->acl;
        $role->save();

        return redirect()->back()->with('success','Successfully added role mapping');
    }

    public function createWandererAccessList(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
            'id' => 'required|string',
            'token' => 'required|string'
        ]);

        $acl = new WandererAccessListInstance();
        $acl->wanderer_url = $request->url;
        $acl->access_list_id = $request->id;
        $acl->access_list_token = $request->token;

        $acl->save();

        return redirect()->back()->with('success','Successfully added wanderer access list');
    }

    public function deleteMapping(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        WandererAccessListRole::destroy($request->id);

        return  redirect()->back()->with('success','Successfully deleted role mapping.');
    }

    public function deleteInstance(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        WandererAccessListInstance::destroy($request->id);

        return  redirect()->back()->with('success','Successfully deleted role mapping.');
    }
}