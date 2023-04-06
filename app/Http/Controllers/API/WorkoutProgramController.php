<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\WorkoutProgram;
use Illuminate\Http\Request;
use Exception;

class WorkoutProgramController extends Controller
{
    public function create(Request $req) { 
        try { 
            $req->validate([ 
                'desc' => ['required', 'string'],
                'img' => ['required', 'string'],
                'title' => ['required', 'string', 'max:255'],
            ]);

            $workout = WorkoutProgram::create([
                'ctgList' => array($req->ctgList),
                'desc' => $req->desc,
                'img' => $req->img,
                'title' => $req->title,
                'workouts' => array($req->workouts),
            ]);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Creating Workout Program Has Failed', 500);
        }

        return ResponseFormatter::success([
            'data' => $workout,
        ], 'Workout Program Created Successfully');
    }

    public function getById(Request $req) { 
        try { 
            $data = WorkoutProgram::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Workout Program is Found', 
                ], 'Workout Program Creation Has Failed', 500);
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
            $data = WorkoutProgram::all(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Workout Program is Found', 
                ], 'Fetching Workout Program Has Failed', 500);
            }

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Workout Program Has Failed', 500);
        }
        return ResponseFormatter::success([
            'total' => Workout::count(),
            'data' => $data, 
        ], 'Workout Program Created Successfully');
    }

    public function edit(Request $req) { 
        try { 
            $req->validate([ 
                'desc' => ['string'],
                'img' => ['string'],
                'title' => ['string', 'max:255'],
            ]);

            $data = WorkoutProgram::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Workout Program is Found', 
                ], 'Editing Workout Program Has Failed', 500);
            }


            $workout = WorkoutProgram::create([
                'ctgList' => array($req->ctgList),
                'desc' => $req->desc,
                'img' => $req->img,
                'title' => $req->title,
                'workouts' => array($req->workouts),
            ]);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Editing Workout Program Has Failed', 500);
        }
        return ResponseFormatter::success($workout, 'Workout Program Created Successfully');
    }

    public function delete(Request $req) { 
        try { 
            // TODO: consider using slug instead of ID
            $data = WorkoutProgram::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Workout Program is Found', 
                ], 'Deleting Workout Program Has Failed', 500);
            }

            $data->delete();
            
        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Deleting Workout Program Has Failed', 500);
        }

        return ResponseFormatter::success($data, 'Workout Program Deleted Successfully');
    }
}
