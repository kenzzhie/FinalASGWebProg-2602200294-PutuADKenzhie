<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;


class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        // Validate the registration data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required',
            'linkedin_username' => 'required',
            'hobby' => 'required|array|min:3',
            'mobile_number' => 'required',
            'age' => 'required|integer|between:20,40'
        ]);

        $works = implode(',', (array) $request->input('hobby'));

        // Create a new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'gender' => $validatedData['gender'],
            'linkedin_username' => $validatedData['linkedin_username'],
            'hobby' => $works,
            'mobile_number' => $validatedData['mobile_number'],
            'register_price' => rand(100000,125000),
            'age'=>$validatedData['age'],
            'profile_path'=>'profile/'.rand(1,3).'.jpg'
        ]);

        // Auth::login($user);
        $loc = session()->get('locale');
        \App::setLocale($loc);
        return redirect('/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);

            return redirect()->route('user.index');
        }

        // If login fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the login page
        $loc = session()->get('locale');
        \App::setLocale($loc);

        return redirect('/');
    }

    public function update_paid(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'payment_amount' => 'required|numeric|min:0',
            'price' => 'required|numeric',
        ]);

        $paymentAmount = $validatedData['payment_amount'];
        $price = $validatedData['price'];
        $difference = $paymentAmount - $price;

        $user = Auth::user();

        $loc = session()->get('locale');
        \App::setLocale($loc);

        if ($difference < 0) {
            // User underpaid
            return redirect()->back()->with('error', 'You are still underpaid $' . number_format(-$difference, 2));
        } elseif ($difference > 0) {
            // User overpaid
            return redirect()->route('handle.overpayment', [
                'amount' => $difference,
                'payment_amount' => $paymentAmount,
                'price' => $price
            ]);
        } else {
            // Payment is exact
            // Mark payment as successful and handle business logic
            $user->has_paid = true;
            $user->save();
            return redirect()->back()->with('success', 'Payment successful!');
        }
    }

    public function handleOverpayment(Request $request)
    {
        $amount = $request->input('amount');
        $paymentAmount = $request->input('payment_amount');
        $price = $request->input('price');

        $loc = session()->get('locale');
        \App::setLocale($loc);

        // Show a view or dialog to handle overpayment
        return view('overpayment', [
            'amount' => $amount,
            'payment_amount' => $paymentAmount,
            'price' => $price
        ]);
    }

    public function processOverpayment(Request $request)
    {
        $action = $request->input('action');
        $paymentAmount = $request->input('payment_amount');
        $price = $request->input('price');
        $user = Auth::user();

        $loc = session()->get('locale');
        \App::setLocale($loc);

        if ($action === 'accept') {
            // Add the overpaid amount to the user's wallet balance
            $amount = $request->input('amount');
            // Assume a wallet balance attribute exists on the user
            $user->coins += $amount;
            $user->has_paid = true;
            $user->save();


            return redirect('/')->with('success', 'The excess amount has been added to your wallet.');
        } else {
            // Redirect back to the payment form to correct the amount
            return redirect()->route('pay')->with('error', 'Please enter the correct payment amount.');
        }
    }

}
