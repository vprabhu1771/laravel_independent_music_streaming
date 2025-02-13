<?php

namespace App\Http\Controllers\api\v2;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::orderby('name','asc')->get();

        return response()->json(['data' => $genres],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, genre $genre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(genre $genre)
    {
        //
    }
}