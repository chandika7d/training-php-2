<?php
class Controller
{
    protected function post($param = ""){
        if(strpos( getHeader("content-type"), "application/json" ) !== false ){
            $jsondata = json_decode(file_get_contents('php://input'), true);
            return empty($param) ? $jsondata : ($jsondata[$param] ?? null);
        }
        return empty($param) ? $_POST : ($_POST[$param] ?? null);
    }

    protected function get($param = ""){
        return empty($param) ? $_GET : ($_GET[$param] ?? null);
    }
}
