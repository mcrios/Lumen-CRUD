<?php

namespace App\Http\Controllers;

class MensajeController extends Controller
{
    function mensaje(){
        return response()->json(['mensaje'=>'Hola'], 200);
    }
}
