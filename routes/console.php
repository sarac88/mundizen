<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * La demo es pública y los visitantes pueden dejar anuncios, mensajes y fotos.
 * Cada madrugada se devuelve al contenido congelado en demo.json para que
 * siempre se encuentre en el mismo estado.
 */
Schedule::command('demo:refresh --force')
    ->dailyAt('03:00')
    ->timezone('Europe/Madrid')
    ->withoutOverlapping()
    ->onOneServer();
