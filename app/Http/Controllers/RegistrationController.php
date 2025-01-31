<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => [
                'required',
                'string',
                'max:255',
                'regex:/^\+?[0-9]{10,15}$/', // Регулярное выражение для проверки номера телефона
                'unique:users,phone_number,NULL,id,username,' . $request->username,
            ],
        ], [
            'phone_number.regex' => 'The phone number format is invalid.',
            'phone_number.unique' => 'The combination of username and phone number must be unique.',
        ]);

        $user = User::create($request->only('username', 'phone_number'));

        $link = Link::create([
            'user_id' => $user->id,
            'unique_link' => Str::uuid(),
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return Redirect::route('link.show', ['link' => $link->unique_link]);
    }
}
