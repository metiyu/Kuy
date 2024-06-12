<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function signUp(Request $request) {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => [
                    'required',
                    'string',
                    'regex:/^08[0-9]{8,10}$/', // Indonesian phone number format
                    'unique:users'
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/', // Must contain at least one letter and one number
                ],
            ], [
                'phone_number.regex' => 'The phone number must start with 08 and contain 10 to 12 digits.',
                'password.regex' => 'The password must contain at least one letter and one number.',
            ]);

            // Create the user
            $user = User::create([
                'full_name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Display a success alert
            Alert::success('Sukses', 'Akun Anda telah berhasil dibuat!');

            // Automatically log in the user after sign up
            Auth::login($user);

            // Redirect to the intended page or home
            return redirect()->back();
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $data = ['openSignUpModal' => true];
            return redirect()->back()->with($data)->withErrors($errors)->withInput();
        }
    }

    public function signIn(Request $request) {
        try {
            $validatedData = $request->validate([
                'emailSignIn' => 'required|string|email',
                'passwordSignIn' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/', // Must contain at least one letter and one number
                ],
            ], [
                'passwordSignIn.regex' => 'Password harus terdiri dari setidaknya satu huruf dan satu angka',
            ]);

            // Attempt to log the user in
            if (Auth::attempt(['email' => $validatedData['emailSignIn'], 'password' => $validatedData['passwordSignIn']])) {
                Alert::success('Sukses', 'Berhasil masuk!');
                // Authentication passed...
                return redirect()->back();
            } else {
                // Authentication failed
                $data = ['openSignInModal' => true];
                return redirect()->back()->with($data)->withErrors(['emailSignIn' => 'Kredensial yang diberikan tidak sesuai dengan data kami'])->withInput();
            }
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $data = ['openSignInModal' => true];
            return redirect()->back()->with($data)->withErrors($errors)->withInput();
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        // Invalidate the current session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
