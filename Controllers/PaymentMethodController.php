<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelPaymentMethod.php";

class PaymentMethodController extends Controller {
    function __construct(){
        parent::__construct();
        $this->payment_method = new ModelPaymentMethod();
    }
    function index(){
        return $this->payment_method->get();
    }

    function show($id){
        return $this->payment_method->getById($id);
    }

    function store(){
        $name = $this->post("name");
        
        if(!$name){
            $errors[] = "name is required";
        }
        if(isset($errors)){
            return ["statusCode" => 400, "errors" => $errors];
        }

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        return $this->payment_method->create($data);
    }
    
    function save($id){
        $name = $this->post("name");

        $data = [];
        if($name){
            $data['name'] = $name;
        }

        return $this->payment_method->update($id, $data);
    }
    
    function destroy(){
        return $this->get();
    }
}