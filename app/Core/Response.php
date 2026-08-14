<?php
namespace Iran\Core;

class Response{

    public static function json($data , $status = 200 , $message = 'success'){
        http_response_code($status);
        header("Content-Type: application/json");
        return json_encode([
            "data" => $data,
            "status" => $status,
            "message" => $message
        ]);
    }
}
