<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\UserData;
use Exception;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function create(Request $req) { 
        try { 
            $req->validate([ 
                'activity' => ['required', 'integer'], 
                'age' => ['required', 'integer'], 
                'calPerDayHold' => ['required', 'integer'], 
                'calPerDayLose' => ['required', 'integer'], 
                'gender' => ['required', 'integer'], 
                'height' => ['required', 'integer'], 
                'imt' => 'required|between:0,99.99', 
                'imtStatus' => ['required', 'string'], 
                'isFilled' => ['required', 'boolean'], 
                'medicalCondition' => ['required', 'integer'], 
                'weight' => ['required', 'integer'], 
                'profileUrl' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]); 

            $email = $req->user()->email;

            if ($req->profileUrl) { 
                $imgName = time().'.'.$req->img->extension();
                // $path = 'images/tips/'.$imgName;
    
                $req->img->move(public_path('images/tips'), $imgName);
            }
            
            $data = UserData::create([ 
                'userEmail' => $email, 
                'activity' => $req->activity,
                'age' => $req->age,
                'calPerDayHold' => $req->calPerDayHold,
                'calPerDayLose' => $req->calPerDayLose,
                'dateOfBirth' => $req->dateOfBirth ?? "",
                'gender' => $req->gender,
                'height' => $req->height,
                'imt' => $req->imt,
                'imtStatus' => $req->imtStatus,
                'isFilled' => $req->isFilled,
                'medicalCondition' => $req->medicalCondition,
                'recommendation' => array($req->recommendation),
                'weight' => $req->weight,
                'profileUrl' => $imgName ?? "",
            ]);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Creating User Data Has Failed', 500);
        }

        return ResponseFormatter::success([
            'userData' => $data, 
        ], 'User Data Created Successfully');

    }   

    public function get(Request $req) { 
        try { 
            $email = $req->user()->email;

            $userData = UserData::where('userEmail', $email)->first();

            if (!$userData) { 
                return ResponseFormatter::error([null, 
                ], 'No User Data is Found', 500);
            }

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching User Data Has Failed', 500);
        }

        return ResponseFormatter::success([
            'userData' => $userData, 
        ], 'User Data Fetched Successfully');
    }

    public function edit(Request $req) { 
        try { 
            $req->validate([ 
                'activity' => ['integer'], 
                'age' => ['integer'], 
                'calPerDayHold' => ['integer'], 
                'calPerDayLose' => ['integer'], 
                'gender' => ['integer'], 
                'height' => ['integer'], 
                'imt' => 'required|between:0,99.99', 
                'imtStatus' => ['string'], 
                'isFilled' => ['boolean'], 
                'medicalCondition' => ['integer'], 
                'weight' => ['integer'], 
                'profileUrl' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]); 

            if ($req->profileUrl) { 
                $imgName = time().'.'.$req->img->extension();
                // $path = 'images/tips/'.$imgName;
    
                $req->img->move(public_path('images/tips'), $imgName);
            }
            
            $data = UserData::where('userEmail', $req->user()->email)->first(); 

            $data->update([ 
                'activity' => $req->activity ?? $data->activity,
                'age' => $req->age ?? $data->age,
                'calPerDayHold' => $req->calPerDayHold ?? $data->calPerDayHold,
                'calPerDayLose' => $req->calPerDayLose ?? $data->calPerDayLose,
                'dateOfBirth' => $req->dateOfBirth ?? $data->dateOfBirth,
                'gender' => $req->gender ?? $data->gender,
                'height' => $req->height ?? $data->height,
                'imt' => $req->imt ?? $data->imt,
                'imtStatus' => $req->imtStatus ?? $data->imtStatus,
                'isFilled' => $req->isFilled ?? $data->isFilled,
                'medicalCondition' => $req->medicalCondition ?? $data->medicalConditoin,
                'recommendation' => array($req->recommendation) ?? $data->recommendation,
                'weight' => $req->weight ?? $data->weight,
                'profileUrl' => $imgName ?? $data->profileUrl,
            ]);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Updating User Data Has Failed', 500);
        }

        return ResponseFormatter::success([
            'userData' => $data, 
        ], 'User Data Updated Successfully');
    }
}