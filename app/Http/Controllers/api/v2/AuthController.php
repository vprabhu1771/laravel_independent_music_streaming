<?php

namespace App\Http\Controllers\api\v2;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login a user and return a token.
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return $user->createToken($request->device_name)->plainTextToken;

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Logout a user by deleting tokens.
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            return response()->json(['message' => 'Tokens deleted successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Register a new user and send a confirmation email.
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'device_name' => 'required|string',
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $recipient = $user->email;
            $subject = 'Welcome to Our Platform';
            $body = 'Thank you for registering!';

            Mail::raw($body, function (Message $message) use ($recipient, $subject) {
                $message->to($recipient);
                $message->subject($subject);
            });

            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get the current authenticated user.
     */
    public function getUser(Request $request)
    {
        $user = $request->user();
        $user->photo_path = url('/storage/' . $user->photo_path);
        return response()->json($user);
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update_profile(Request $request)
    {
        try {
            $user = $request->user();

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:6',
                'device_name' => 'required|string',
            ]);

            $data = [];
            if ($request->filled('name')) {
                $data['name'] = $request->input('name');
            }
            if ($request->filled('email')) {
                $data['email'] = $request->input('email');
            }
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->input('password'));
            }
            $user->update($data);

            return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        // Code for updating other users (if needed)
    }

    public function destroy(User $user)
    {
        // Code for deleting a user (if needed)
    }
}