<?php
require_once "Controller.php";

class AppController extends Controller {
    function __construct(){
    }
    function index(){
        $app_meta = include APP_PATH . "/Config/app.php";
        return [
            "message" => "Welcome to {$app_meta['app_name']} {$app_meta['app_version']}",
            "about" => $app_meta,
            "routes" => get("router")
        ];
    }
}