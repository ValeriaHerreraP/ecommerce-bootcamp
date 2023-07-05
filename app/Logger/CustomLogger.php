<?php

namespace App\Logger;

use Illuminate\Support\Facades\Log;

class CustomLogger {

    public static function logErrorPasarelaPago(\Exception $e):void
    {
        $user = auth()->user()->name;
        $log = "Al usuario " . $user . " se le genera el error al crear la sesion de pago. " . $e->getMessage();
        Log::error($log);
    }

}