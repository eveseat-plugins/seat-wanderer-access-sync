<?php

namespace RecursiveTree\Seat\WandererAccessSync\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveTree\Seat\WandererAccessSync\Models\WandererAccessListRole;
use Seat\Web\Http\Controllers\Controller;
use Seat\Web\Models\Acl\Role;

class SettingsController extends Controller
{
    public function list()
    {
        $roles = WandererAccessListRole::all();
        $seat_roles = Role::all();

        return view('wanderer-access-sync::list', compact('roles', 'seat_roles'));
    }

    public function createMapping(Request $request)
    {
        $request->validate([
            'role' => 'required|integer',
            'url' => 'required|string',
            'id' => 'required|string',
            'token' => 'required|string'
        ]);

        $role = new WandererAccessListRole();
        $role->role_id = $request->role;
        $role->wanderer_url = $request->url;
        $role->access_list_id = $request->id;
        $role->access_list_token = $request->token;
        $role->save();

        return redirect()->back();
    }
}