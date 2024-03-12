<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function success($data = [])
    {
        return [
            'status' => true,
            'code' => 200,
            'message' => '',
            'data' => $data,
            'time' => date('Y-m-d H:i:s')
        ];
    }

    public function fail($code, $data = [])
    {
        return [
            'status' => false,
            'code' => $code,
            'message' => '',
            'data' => $data,
            'time' => date('Y-m-d H:i:s')
        ];
    }
}
