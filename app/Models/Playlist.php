<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable =[
        'customer_id',
        'song_id'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    
    public function song()
    {
        return $this->belongsTo(Song::class,'song_id');
    }

}