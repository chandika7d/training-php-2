<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelPaymentMethod.php";

class PaymentMethodController extends Controller {
    public function __construct(){
        $this->payment_method = new ModelPaymentMethod();
    }
    public function index(){
        return $this->payment_method->get();
    }

    public function show($id){
        return $this->payment_method->getById($id);
    }

    public function store(){
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
    
    public function save($id){
        $name = $this->post("name");

        $data = [];
        if($name){
            $data['name'] = $name;
        }

        return $this->payment_method->update($id, $data);
    }
    
    public function destroy($id){
        return $this->get();
    }
}