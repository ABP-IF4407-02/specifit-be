<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\Request;
use Exception;

class WorkoutController extends Controller
{
    public function create(Request $req) { 
        try { 
            $req->validate([ 
                'desc' => ['required', 'string'],
                'est' => ['required', 'string'],
                'img' => ['required', 'string'],
                'title' => ['required', 'string', 'max:255'],
                'totalEst' => ['required', 'string'],
                'vid' => ['required', 'string'],
                // 'workoutId' => ['required   ', 'string'],
            ]);

            $workout = Workout::create([
                'ctgList' => array($req->ctgList),
                'desc' => $req->desc,
                'est' => $req->est,
                'img' => $req->img,
                'title' => $req->title,
                'totalEst' => $req->totalEst,
                'vid' => $req->vid,
                'workoutEsts' => array($req->workoutEsts),
                'workoutLists' => array($req->workoutLists),
                // 'workoutId' => $req->workoutId,
            ]);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Creating Workout Has Failed', 500);
        }

        return ResponseFormatter::success([
            'data' => $workout,
        ], 'Workout Created Successfully');
    }

    public function getById(Request $req) { 
        try { 
            $data = Workout::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Workout is Found', 
                ], 'Workout Creation Has Failed', 500);
            }

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Workout Creation Has Failed', 500);
        }
        return ResponseFormatter::success($data, 'Workout Created Successfully');
    }

    public function getAll() { 
        try { 
            $data = Workout::all(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Workout is Found', 
                ], 'Fetching Workout Has Failed', 500);
            }

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Workout Has Failed', 500);
        }
        return ResponseFormatter::success([
            'total' => Workout::count(),
            'data' => $data, 
        ], 'Workout Created Successfully');
    }

    public function edit(Request $req) { 
        try { 
            $req->validate([ 
                'desc' => ['string'],
                'est' => ['integer'],
                'img' => ['string'],
                'title' => ['string', 'max:255'],
                'totalEst' => ['integer'],
                'vid' => ['string'],
                'workoutId' => ['integer'],
            ]);

            $data = Workout::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Workout is Found', 
                ], 'Editing Workout Has Failed', 500);
            }


            $workout = Workout::create([
                'ctgList' => array($req->ctgList),
                'desc' => $req->desc,
                'est' => $req->est,
                'img' => $req->img,
                'title' => $req->title,
                'totalEst' => $req->totalEst,
                'vid' => $req->vid,
                'workoutEsts' => array($req->workoutEsts),
                'workoutLists' => array($req->workoutLists),
                'workoutId' => $req->workoutId,
            ]);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Editing Workout Has Failed', 500);
        }
        return ResponseFormatter::success($workout, 'Workout Created Successfully');
    }

    public function delete(Request $req) { 
        try { 
            // TODO: consider using slug instead of ID
            $data = Workout::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Workout is Found', 
                ], 'Deleting Workout Has Failed', 500);
            }

            $data->delete();
            
        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Deleting Workout Has Failed', 500);
        }

        return ResponseFormatter::success($data, 'Workout Deleted Successfully');
    }
}
