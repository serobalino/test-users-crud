<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Crud/Roles/index', ['roles' => Team::all(['id','name','is_admin','is_default'])]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Crud/Roles/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRole $request)
    {
        $new = new Team();
        $new->user_id = Auth::user()->id;
        $new->name = $request->name;
        $new->personal_team = false;
        $new->is_admin = $request->is_admin;
        $new->is_default = $request->is_default;
        $new->save();
        return redirect()->route('roles.index')->with('message', "The role $new->name was created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Team::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        return Inertia::render('Crud/Roles/edit',['rol' => Team::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRole $request, $id)
    {
        $update = Team::find($id);
        $update->user_id = Auth::user()->id;
        $update->name = $request->name;
        $update->personal_team = false;
        $update->is_admin = $request->is_admin;
        $update->is_default = $request->is_default;
        $update->save();
        return redirect()->route('roles.index')->with('message', "The role $update->name was updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $delete = Team::find($id);
        if(count($delete->users)){
            return redirect()->route('roles.index')->with('message', "$delete->name cannot be deleted because he has linked users");
        }else{
            $delete->delete();
            return redirect()->route('roles.index')->with('message', "The role $delete->name was deleted successfully");
        }
    }
}
