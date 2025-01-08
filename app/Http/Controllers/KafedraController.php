<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kafedra;
class KafedraController extends Controller
{
    public function __invoke($fakultet_id)
    {

        $kafedra = Kafedra::where('fakultet_id', $fakultet_id)->get();
        $message = 'Kafedra not found.';
        if(count($kafedra) == 0)
        {
           
            return response()->json($message);
        }
        return response()->json($kafedra);
        // return response(['kafedra' => Kafedra::all()], 200);
    }
}

