<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\Team;
use App\Models\User;
use App\Notifications\UserCreateNotification;
use App\Notifications\UserDeleteNotification;
use App\Notifications\UserUpdateNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Crud/Users/index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Crud/Users/create',['roles'=>Team::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUser $request)
    {
        $new = new User();
        $new->name = $request->name;
        $new->lastName = $request->lastName;
        $new->phone = $request->phone;
        $new->address = $request->address;
        $new->birthdate = $request->birthDate;
        $new->email = $request->email;
        $new->password = Hash::make($request->password);
        $new->save();
        foreach ($request->roles as $team){
            $rol = Team::find($team);
            $new->teams()->attach($rol);
            $new->switchTeam($rol);
        }
        $new->notify(new UserCreateNotification($request));
        return redirect()->route('users.index')->with('message', "The user $new->name was created successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(User::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return Inertia::render('Crud/Users/edit',['data' => $user,'roles'=>Team::all(),'currrol'=>$user->teams]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUser $request, $id)
    {
        $update = User::find($id);
        $update->name = $request->name;
        $update->lastName = $request->lastName;
        $update->phone = $request->phone;
        $update->address = $request->address;
        $update->birthdate = $request->birthDate;
        $update->email = $request->email ? $request->email : $update->email;
        $update->password = $request->password ? Hash::make($request->password) : $update->password;
        $update->save();
        $update->teams()->detach();
        foreach ($request->roles as $team){
            $rol = Team::find($team);
            $update->teams()->attach($rol);
            $update->switchTeam($rol);
        }
        $update->notify(new UserUpdateNotification());
        return redirect()->route('users.index')->with('message', "The user $update->name was updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $delete = User::find($id);
        $delete->teams()->detach();
        $delete->notify(new UserDeleteNotification());
        $delete->delete();
        return redirect()->route('users.index')->with('message', "The user $delete->name was deleted successfully");
    }
}
