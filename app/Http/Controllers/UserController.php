<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.karyawan.index', [
            "datas" => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.karyawan.create', [
            // 'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|max:255',
            'nama' => 'required|max:255',
            'email' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'alamat' => 'required|max:255',
            'role' => 'required|max:255',
          ]);

          User::create($validatedData);

          return redirect('/users')->with('success', 'New Karyawan has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.admin.karyawan.show', [
            'data' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.admin.karyawan.edit', [
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = ([
            'username' => 'required|max:255',
            'password' => 'required|max:255',
            'nama' => 'required|max:255',
            'email' => 'required|max:255',
            'no_telp' => 'required|numeric',
            'alamat' => 'required|max:255',
            'role' => 'required|max:255',
        ]);

        $validatedData = $request->validate($rules);

        User::where('id', $user->id)
            ->update($validatedData);

        return redirect('/users')->with('success', 'Karyawan has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/users')->with('success', 'Karyawan has been deleted!');
    }
}
