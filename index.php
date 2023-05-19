<?php
define('APP_PATH', __DIR__);
define('SYS_GLOBAL_VAR', '_d326_fw');
// ini_set('display_errors', '1');
session_start();

function set($name, $value)
{
    $GLOBALS[SYS_GLOBAL_VAR][$name] = $value;
}

function get($name, $default = null)
{
    return isset($GLOBALS[SYS_GLOBAL_VAR][$name]) ? $GLOBALS[SYS_GLOBAL_VAR][$name] : $default;
}

function run()
{
    set('baseUrl', $_SERVER['SCRIPT_NAME']);
    $route = explode("/", rtrim($_SERVER['PATH_INFO'], '/'));
    $classname = ucfirst($route[1]) . "Controller";
    $functionname = $route[2] ?? "";

    if (empty($classname)) {
        $classname = "HomeController";
    }
    if (empty($functionname)) {
        $functionname = "index";
    }
    set('classname', $classname);

    try {
        include(APP_PATH . "/Controllers/{$classname}.php");
        $class = new $classname();
        return $class->$functionname();
    } catch (\Throwable $th) {
        return [
            "data" => "Not Found",
            "code" => 404
        ];
    }
}

$callback = run();
header('Content-type: application/json; charset=utf-8');
if (isset($callback["code"])) {
    http_response_code($callback["code"]);
    echo json_encode($callback["data"]);
} else {
    http_response_code(200);
    echo json_encode($callback);
}
die();