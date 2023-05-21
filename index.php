<?php
define('APP_PATH', __DIR__);
define('SYS_GLOBAL_VAR', '_d326_fw');
ini_set('display_errors', '1');
session_start();
header('Content-type: application/json; charset=utf-8');

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
    require_once(APP_PATH . "/Config/router.php");
    $route = explode("/", rtrim($_SERVER['PATH_INFO'] ?? "/", '/'));
    $result = Router::check(get("router"), $_SERVER['REQUEST_METHOD'], $route);
    $classname = "";
    $functionname = "";

    if ($result["selected"]) {
        $classname = $result["selected"]["controller"];
        $functionname = $result["selected"]["function"];
    }

    try {
        require_once(APP_PATH . "/Controllers/{$classname}.php");
        $class = new $classname();
        return call_user_func_array([$class, $functionname], $result["params"]);
    } catch (\Throwable $th) {
        if (ini_get("display_errors") == 1)
            return [
                "data" => ["message" => $th->getMessage()],
                "code" => 404
            ];
        else
            return [
                "data" => ["message" => "Not Found"],
                "code" => 404
            ];
    }
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