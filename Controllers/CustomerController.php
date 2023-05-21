<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelCustomer.php";

class CustomerController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_customer = new ModelCustomer();
    }
    function index(){
        return $this->model_customer->get();
    }

    function show($id){
        return $this->model_customer->getById($id);
    }

    function store(){
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
    
    function save($id){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");
        $phone = $this->post("phone");
        $email = $this->post("email");
        $password = $this->post("password");

        return $id;

        return $this->model_customer->update($id, [
            'name' => $name,
            'idcountry' => $idcountry,
            'phone' => $phone,
            'email' => $email,
            'password' => DB::RAW("SHA1('$password')"),
        ]);
    }
    
    function destroy(){
        return $this->get();
    }
}