<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return Inertia::render('Crud/Users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $new = new User();
        $new->name = $request->name;
        $new->lastName = $request->lastName;
        $new->phone = $request->phone;
        $new->address = $request->address;
        $new->birthdate = $request->birthdate;
        $new->email = $request->email;
        $new->password = Hash::make($request->password);
        $new->save();
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
        return Inertia::render('Crud/Users/edit',['user' => User::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $update = User::find($id);
        $update->name = $request->name;
        $update->lastName = $request->lastName;
        $update->phone = $request->phone;
        $update->address = $request->address;
        $update->birthdate = $request->birthdate;
        $update->email = $request->email;
        $update->password = $request->password ? Hash::make($request->password) : $update->password;
        $update->save();
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
        $delete->delete();
        return redirect()->route('users.index')->with('message', "The user $delete->name was deleted successfully");
    }
}
