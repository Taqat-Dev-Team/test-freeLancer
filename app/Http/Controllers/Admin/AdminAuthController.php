<?php

namespace App\Http\Controllers\Admin;
// You might need to adjust your controller's namespace

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Display the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login'); // Ensure the path is correct for your Blade file
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $remember = $request->filled('remember');
            if (Auth::guard('admin')->attempt($credentials, $remember)) {
                $request->session()->regenerate();
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Login successful!',
                        'redirect' => route('admin.dashboard'),
                    ], 200);
                }

                return redirect()->intended(route('admin.dashboard'));
            }

            // 2. Authentication failed
            $errorMessage = 'These credentials do not match our records.';
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $errorMessage,
                    'errors' => [
                        'email' => [$errorMessage], // You can return the error for a specific field
                    ],
                ], 401); // 401 Unauthorized
            }

            return redirect()->back()->withErrors([
                'email' => $errorMessage,
            ]);

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.', // General message
                    'errors' => $e->errors(),
                ], 422); // 422 Unprocessable Entity
            }
            return redirect()->back()->withErrors($e->errors())->withInput($request->only('email'));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Use the appropriate guard
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
