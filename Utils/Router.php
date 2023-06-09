<?php

class Router
{
    public static function get($url, array $params)
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

    public static function post($url, array $params)
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

    public static function put($url, array $params)
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

    public static function delete($url, array $params)
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

    public static function check($router, $method, $paths)
    {
        $_route = $router[$method];
        $selected = null;
        $params = $paths;
        foreach ($_route as $value) {
            $route_path = explode("/", rtrim($value["url"] ?? "/", '/'));
            if (count($route_path) == count($paths)) {
                $notsame = false;
                foreach ($route_path as $key => $value2) {
                    if ($value2 !== $paths[$key] && $value2 !== "$") {
                        $notsame = true;
                    }
                    if ($value2 !== "$") {
                        unset($params[$key]);
                    }
                }

                if (!$notsame) {
                    $selected = $value;
                }
            }

            if ($selected) {
                break;
            }
        }

        return [
            'selected' => $selected,
            'params' => $params,
        ];
    }
}