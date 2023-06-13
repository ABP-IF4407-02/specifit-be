<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Helpers\ResponseFormatter;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getImage(Request $req) { 
        try { 
            $path = public_path($req->url);
            $file = file_get_contents($path);
            $type = mime_content_type($path);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Image Has Failed', 500);
        }   
        
        // return ResponseFormatter::success([
        //     'data' => $file,
        //     'Content-Type' => $type], 
        //     'Image Fetched Successfully'
        // );

        return new Response($file, 200, ['Content-Type' => $type]);
    }

    public function getTipsImage(Request $req) { 
        try { 
            $path = public_path('images/tips/'.$req->url);
            $file = file_get_contents($path);
            $type = mime_content_type($path);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Image Has Failed', 500);
        }   
        
        // return ResponseFormatter::success([
        //     'data' => $file,
        //     'Content-Type' => $type], 
        //     'Image Fetched Successfully'
        // );

        return new Response($file, 200, ['Content-Type' => $type]);
    }

    public function getWorkoutImage(Request $req) { 
        try { 
            $path = public_path('images/workout/'.$req->url);
            $file = file_get_contents($path);
            $type = mime_content_type($path);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Image Has Failed', 500);
        }   
        
        // return ResponseFormatter::success([
        //     'data' => $file,
        //     'Content-Type' => $type], 
        //     'Image Fetched Successfully'
        // );

        return new Response($file, 200, ['Content-Type' => $type]);
    }

    public function getWorkoutProgramImage(Request $req) { 
        try { 
            $path = public_path('images/workoutprogram/'.$req->url);
            $file = file_get_contents($path);
            $type = mime_content_type($path);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Image Has Failed', 500);
        }   
        
        // return ResponseFormatter::success([
        //     'data' => $file,
        //     'Content-Type' => $type], 
        //     'Image Fetched Successfully'
        // );

        return new Response($file, 200, ['Content-Type' => $type]);
    }

    public function getUserDataImage(Request $req) { 
        try { 
            // TODO: add folder for profile picture
            $path = public_path('images/userdata/'.$req->url);
            $file = file_get_contents($path);
            $type = mime_content_type($path);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Image Has Failed', 500);
        }   
        
        // return ResponseFormatter::success([
        //     'data' => $file,
        //     'Content-Type' => $type], 
        //     'Image Fetched Successfully'
        // );

        return new Response($file, 200, ['Content-Type' => $type]);
    }
}
