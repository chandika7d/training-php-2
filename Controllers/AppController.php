<?php
require_once "Controller.php";

class AppController extends Controller {

    public function index(){
        $appmeta = include APP_PATH . "/Config/app.php";
        return [
            "message" => "Welcome to {$appmeta['app_name']} {$appmeta['app_version']}",
            "about" => $appmeta,
            "routes" => get("router")
        ];
    }
}