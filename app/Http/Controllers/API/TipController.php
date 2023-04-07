<?php

namespace App\Http\Controllers\API;

use App\Models\Tip;
use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TipController extends Controller
{
    public function create(Request $req) { 
        try { 
            $req->validate([
                'title' => ['required', 'string'],
                'author' => ['required', 'string'],
                'article' => ['required', 'string'],
                'img' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]); 

            $imgName = time().'.'.$req->img->extension();
            $path = 'public/images/tips/'.$imgName;

            $req->img->move(public_path('images/tips'), $imgName);

            $tip = Tip::create([ 
                'title' => $req->title, 
                'author' => $req->author, 
                'article' => $req->article, 
                'img' => $path, 
            ]);

        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Creating Tip Has Failed', 500);
        }

        return ResponseFormatter::success([
            'id' => $tip->id, 
            'title' => $req->title, 
            'author' => $req->author, 
            'article' => $req->article, 
            'img' => $path, 
        ], 'Tip Created Successfully');
    }

    public function getById(Request $req) { 
        try { 

            // TODO: consider using slug instead of ID
            $data = Tip::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Tip is Found', 
                ], 'Fetching Tip Has Failed', 500);
            }
            
        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Tip Has Failed', 500);
        }

        return ResponseFormatter::success($data, 'Tip Fetched Successfully');
    }

    public function getAll() { 
        try { 

            $data = Tip::all(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Tip is Found', 
                ], 'Fetching Tip Has Failed', 500);
            }
            
        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Fetching Tip Has Failed', 500);
        }

        return ResponseFormatter::success([
            'total' => Tip::count(),
            'data' => $data, 
        ], 'Tip Fetched Successfully');
    }

    public function edit(Request $req) { 
        try { 
            $req->validate([
                'title' => ['required', 'string'],
                'author' => ['required', 'string'],
                'article' => ['required', 'string'],
                'img' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]); 
            // TODO: consider using slug instead of ID
            $data = Tip::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Tip is Found', 
                ], 'Editing Tip Has Failed', 500);
            }

            // $path = $req->file('img')->store('public/images/');
            $imgName = time().'.'.$req->img->extension();
            $path = 'public/images/tips/'.$imgName;
            $req->img->move(public_path('images/tips'), $imgName);

            $data->update([ 
                'title' => $req->title ?? $data->title, 
                'author' => $req->author ?? $data->author, 
                'article' => $req->article ?? $data->article, 
                'img' => $path ?? $data->img, 
            ]);

            
            
        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Editing Tip Has Failed', 500);
        }

        return ResponseFormatter::success($data, 'Tip Edited Successfully');
    }

    public function delete(Request $req) { 
        try { 

            // TODO: consider using slug instead of ID
            $data = Tip::where('_id', $req->id)->first(); 

            if (!$data) { 
                return ResponseFormatter::error([ 
                    'error' => 'No Tip is Found', 
                ], 'Deleting Tip Has Failed', 500);
            }

            $data->delete();
            
        } catch (Exception $err) { 
            return ResponseFormatter::error([ 
                'error' => $err->getMessage(), 
            ], 'Deleting Tip Has Failed', 500);
        }

        return ResponseFormatter::success($data, 'Tip Deleted Successfully');
    }
}
