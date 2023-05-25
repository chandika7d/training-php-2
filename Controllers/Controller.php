<?php
class Controller
{
    function __construct()
    {
    }

    function post($param = ""){
        if(strpos( getHeader("content-type"), "application/json" ) !== false ){
            $json_data = json_decode(file_get_contents('php://input'), true);
            return empty($param) ? $json_data : ($json_data[$param] ?? null);
        }
        return empty($param) ? $_POST : ($_POST[$param] ?? null);
    }

    function get($param = ""){
        return empty($param) ? $_GET : ($_GET[$param] ?? null);
    }
}