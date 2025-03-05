<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'username' => ['required','max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255']
        ]);

        // $user = auth()->user();
        // $user->username = $request->get('username');
        // $user->firstname = $request->get('firstname');
        // $user->lastname = $request->get('lastname');
        // $user->email = $request->get('email');
        // $user->address = $request->get('address');
        // $user->city = $request->get('city');
        // $user->country = $request->get('country');
        // $user->postal = $request->get('postal');
        // $user->about = $request->get('about');
        // $user->save();
        // return back()->with('succes', 'Profile succesfully updated');
    }
}
