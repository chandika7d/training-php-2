<?php
require_once "Controller.php";

class AppController extends Controller {
    function __construct(){
    }
    function index(){
        return [
            "message" => "Welcome to gocar api",
            "routes" => get("router")
        ];
    }
}