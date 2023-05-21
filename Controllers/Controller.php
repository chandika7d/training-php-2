<?php
class Controller
{
    function __construct()
    {
    }

    function post($param = ""){
        return empty($param) ? $_POST : ($_POST[$param] ?? null);
    }

    function get($param = ""){
        return empty($param) ? $_GET : ($_GET[$param] ?? null);
    }
}