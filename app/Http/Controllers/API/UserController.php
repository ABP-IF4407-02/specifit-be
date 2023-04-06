<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
// TODO: add token limit time
{
    public function register(Request $req) { 
        try { 
            $req->validate([
                'name' => ['required', 'string', 'max:255'], 
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'], 
                'phone' => ['required', 'string', 'max:20'], 
        
                // TODO: validate password rules
                'password' => [
                    'required', 'string',
                    Password::min(8)
                    ->letters() 
                    ->numbers()
                    ->symbols()
                ], 
            ]);
            
            User::create([ 
                'name' => $req->name, 
                'email' => strtolower($req->email), 
                'phone' => $req->phone, 
                'password' => Hash::make($req->password), 
                'role' => $req->role ?? 1, 
            ]);

            $user = User::where('email', $req->email)->first();
            
            $token = $user->createToken('authToken', ['token_type' => 'Bearer'])->plainTextToken;

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'User Registrasion Failed', 500);
        }

        return ResponseFormatter::success([
            'token_type' => 'Bearer', 
            'token' => $token, 
            'user' => $user, 
        ], 'User Registered');
    }

    public function login(Request $req) { 
        try { 
            $req->validate([
                'email' => ['required', 'email'], 
                'password' => 'required', 
            ]); 

            $credentials = request(['email', 'password']); 

            if (!Auth::attempt($credentials)) { 
                return ResponseFormatter::error([ 
                    'error' => 'Email or Password is Wrong', 
                ], 'Authentication Failed', 500);
            }

            $user = User::where('email', $req->email)->first();
            // double check
            if (!Hash::check($req->password, $user->password, [])) { 
                throw new Exception('Email or Password is Wrong');
            }

            $token = $user->createToken('authToken', ['token_type' => 'Bearer'])->plainTextToken;

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Login Failed', 500);
        }

        return ResponseFormatter::success([
            'token_type' => 'Bearer', 
            'token' => $token, 
            'user' => $user, 
        ], 'User Authenticated');
    }

    public function get(Request $req) { 
        try { 
            $data = User::where('email', $req->user()->email)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No User Data is Found', 
                ], 'Fetching User Data Has Failed', 500);
            }
            
        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching User Data Has Failed', 500);
        }

        return ResponseFormatter::success($data, 'Data Fetched Successfully');
    }

    public function edit(Request $req) { 
        try { 
            $req->validate([
                'name' => ['string', 'max:255'], 
                'phone' => ['string', 'max:20'], 
            ]);

            $data = User::where('email', $req->user()->email)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No User Data is Found', 
                ], 'Fetching User Data Has Failed', 500);
            }

            $data->update([ 
                'name' =>  $req->name ?? $data->name,
                'phone' => $req->phone ?? $data->phone,
            ]);
            
        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching User Data Has Failed', 500);
        }

        return ResponseFormatter::success($data, 'Data Updated Successfully');
    }
}
