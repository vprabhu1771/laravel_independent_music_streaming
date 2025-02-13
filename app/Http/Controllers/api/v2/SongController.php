<?php

namespace App\Http\Controllers\api\v2;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{

    public function index(Request $request)
    {
    
        if($request->has('genre_id'))
        {
            $songs=Song::where('genre_id',$request->input('genre_id'))
                              ->orderBy('name','asc')
                              ->get();
        }
        elseif ($request->has('brand_id')) 
        {
            $songs=Song::where('brand_id',$request->input('brand_id'))
                              ->orderBy('name','asc')
                              ->get();
        }
        else
        {
            $songs = Song::orderby('name','asc')->get();
        }

        $transformedSongs =$songs->map(function($row){

            return [
                'id'=>$row->id,
                'name'=>$row->name,
                'image_path'=>$row->GetImagePath(),
                'song_path' => $row->GetSongPath()
            ];
        });
        


        return response()->json(['data' => $transformedSongs],200);
    }   

}