<?php
include "Controller.php";
require_once "./Models/ModelCustomer.php";

class CustomerController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_customer = new ModelCustomer();
    }
    function index(){
        return $this->model_customer->get();
    }

    function create(){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");
        $phone = $this->post("phone");
        $email = $this->post("email");
        $password = $this->post("password");

        return $this->model_customer->create([
            'name' => $name,
            'idcountry' => $idcountry,
            'phone' => $phone,
            'email' => $email,
            'password' => DB::RAW("SHA1('$password')"),
        ]);
    }
}