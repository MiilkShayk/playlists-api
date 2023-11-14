<?php

namespace App\Listeners;

use App\Events\MusicaUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class MusicaUpdatedListener implements ShouldQueue
{
    public function handle(MusicaUpdated $event)
    {
        $musica = $event->musica;

        // Lógica para atualizar associações nas playlists relevantes
        // ...

        // Exemplo: atualizar categorias em playlists
        $playlists = $musica->playlists;
        foreach ($playlists as $playlist) {
            $playlist->categorias()->sync($musica->categorias->pluck('id'));
        }
    }
}
