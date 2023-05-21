<?php
define('APP_PATH', __DIR__);
define('SYS_GLOBAL_VAR', '_d326_fw');
ini_set('display_errors', '1');
session_start();
header('Content-type: application/json; charset=utf-8');

function run()
{
    $route = explode("/", rtrim($_SERVER['PATH_INFO'] ?? "", '/'));
    $classname = $route[1] ?? "";
    $functionname = $route[2] ?? "";

    if (empty($classname)) {
        $classname = "AppController";
    } else {
        $classname = ucfirst($route[1]) . "Controller";
    }

    if (empty($functionname)) {
        $functionname = "index";
    }

    // try {
    include(APP_PATH . "/Controllers/{$classname}.php");
    $class = new $classname();
    return $class->$functionname();
    // } catch (\Throwable $th) {
    //     return [
    //         "data" => "Not Found",
    //         "code" => 404
    //     ];
    // }
}

$callback = run();
if (isset($callback["code"])) {
    http_response_code($callback["code"]);
    echo json_encode($callback["data"]);
} else {
    http_response_code(200);
    echo json_encode($callback);
}
die();