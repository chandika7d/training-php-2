<?php
include "Controller.php";
require_once "./Models/ModelCustomer.php";

class CustomerController extends Controller {
    function __construct(){
        $this->model_customer = new ModelCustomer();
    }
    function index(){
        return $this->model_customer->get();
    }

    function create(){
        return [
            "code" => "200",
            "data" => "ini fungsi create Controller Home"
        ];
    }
}