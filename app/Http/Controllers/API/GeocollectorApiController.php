<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class GeocollectorApiController extends Controller
{
    public function index(Request $request)
    {
        
        $data = $request->json()->all();
        // Log::info($data);
    }

}
