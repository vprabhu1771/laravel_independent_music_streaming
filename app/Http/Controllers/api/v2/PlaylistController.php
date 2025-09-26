<?php

namespace App\Http\Controllers\api\v2;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }

    // Add a song to a playlist
    public function addToPlaylist(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        // Get authenticated user
        $user = $request->user();

        // Check if the song is already in the playlist
        if (Playlist::where('customer_id', $user->id)->where('song_id', $validated['song_id'])->exists()) {
            return response()->json(['message' => 'Song is already in the playlist'], 409);
        }

        // Create a new playlist entry
        $playlist = Playlist::create([
            'customer_id' => $user->id,
            'song_id' => $validated['song_id'],
        ]);

        return response()->json(['message' => 'Song added to playlist successfully', 'playlist' => $playlist], 201);
    }

    // Remove a song from a playlist
    public function removeFromPlaylist(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        // Get authenticated user
        $user = $request->user();

        // Find and delete the playlist entry
        $playlist = Playlist::where('customer_id', $user->id)
                            ->where('song_id', $validated['song_id'])
                            ->first();

        if (!$playlist) {
            return response()->json(['message' => 'Song not found in the playlist'], 404);
        }

        $playlist->delete();

        return response()->json(['message' => 'Song removed from playlist successfully']);
    }

    // Get the playlist of the authenticated customer
    public function getPlaylist(Request $request)
    {
        // Get authenticated user
        $user = $request->user();

        // Fetch the playlist for the authenticated user
        $playlists = Playlist::where('customer_id', $user->id)->with('song')->get();

        $transformedPlaylists =$playlists->map(function($row){

            return [
                'id'=>$row->id,
                'name'=>$row->name,
                // 'image_path'=>$row->GetLogoImage(),
            ];
        });

        if ($playlists->isEmpty()) {
            return response()->json(['message' => 'No songs found in the playlist'], 404);
        }

        return response()->json(['data' => $transformedPlaylists], 200);
    }
}
