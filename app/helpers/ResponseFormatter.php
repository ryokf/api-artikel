<?php

namespace App\helpers;

class ResponseFormatter
{
    static function success($data, $status = 'success', $code = 200)
    {
        if (!$data) {
            die;
        }

        return [
            "meta" => [
                'code' => $code,
                'status' => $status,
            ], "data" => $data
        ];
    }

    static function error($msg, $data = null, $status = 'error', $code = 404)
    {
        if ($data) {
            die;
        }

        return [
            "meta" => [
                'code' => $code,
                'status' => $status,
                'msg' => $msg
            ], "data" => $data
        ];
    }
}
