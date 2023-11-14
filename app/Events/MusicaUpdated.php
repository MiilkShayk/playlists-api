<?php

namespace App\Events;

use App\Models\Musicas;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MusicaUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $musica;

    public function __construct(Musicas $musica)
    {
        $this->musica = $musica;
    }
}