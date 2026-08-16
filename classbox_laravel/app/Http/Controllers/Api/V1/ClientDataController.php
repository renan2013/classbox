<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ClientData;

class ClientDataController extends Controller
{
    public function show()
    {
        $data = ClientData::first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
