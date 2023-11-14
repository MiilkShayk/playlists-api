<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlists extends Model
{
    use HasFactory;
    public function musicas()
    {
        return $this->belongsToMany(Musicas::class, 'playlist_musicas', 'playlist_id', 'musicas_id');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'users_id');
}
    protected $fillable = ['name'];
    public $timestamps = false;
}
