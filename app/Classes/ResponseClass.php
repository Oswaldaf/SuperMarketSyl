<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class ResponseClass
{
    public static function success(
        $message = "Opération effectuée avec succès !"
    ) {
        return back()->with("success", $message);
    }

    public static function rollback(
        $message = "Une erreur de source inconnue est survenur. Prière de réessayer."
    ) {
        DB::rollBack();
        return back()->with("error", $message);
    }
}
