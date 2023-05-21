<?php

class Router
{
    static function get($url, array $params)
    {
        $router = get("router", [
            "GET" => [],
            "POST" => [],
            "PUT" => [],
            "DELETE" => [],
        ]);
        $router["GET"][] = [
            "url" => $url,
            "controller" => $params[0],
            "function" => $params[1] ?? "index"
        ];

        set("router", $router);
    }

    static function post($url, array $params)
    {
        $router = get("router", [
            "GET" => [],
            "POST" => [],
            "PUT" => [],
            "DELETE" => [],
        ]);
        $router["POST"][] = [
            "url" => $url,
            "controller" => $params[0],
            "function" => $params[1] ?? "store"
        ];

        set("router", $router);
    }

    static function put($url, array $params)
    {
        $router = get("router", [
            "GET" => [],
            "POST" => [],
            "PUT" => [],
            "DELETE" => [],
        ]);
        $router["PUT"][] = [
            "url" => $url,
            "controller" => $params[0],
            "function" => $params[1] ?? "save"
        ];

        set("router", $router);
    }

    static function delete($url, array $params)
    {
        $router = get("router", [
            "GET" => [],
            "POST" => [],
            "PUT" => [],
            "DELETE" => [],
        ]);
        $router["PUT"][] = [
            "url" => $url,
            "controller" => $params[0],
            "function" => $params[1] ?? "destroy"
        ];

        set("router", $router);
    }

    static function check($router, $method, $paths){
        $_route = $router[$method];
        $selected = null;
        $params = null;
        foreach ($_route as $value) {
            $route_path = explode("/", rtrim($value["url"] ?? "/", '/'));
            if(count($route_path) == count($paths)){
                $notsame = false;
                foreach ($route_path as $key => $value2) {
                    if($value2 !== $paths[$key] && $value2 !== "$"){
                        $notsame = true;
                    }
                    unset($route_path[$key]);
                }

                if(!$notsame){
                    $selected = $value;
                    $params = $route_path;
                }
            }

            if($selected){
                break;
            }
        }

        return [
            'selected' => $selected,
            'params' => $params,
        ];
    }
}