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
        $saldo = $this->post("saldo");
        $point = $this->post("point");

        $errors = [];
        if(!$name){
            $errors[] = "name is required";
        }
        if(!$idcountry){
            $errors[] = "idcountry is required";
        }else{
            if(!is_numeric($idcountry)){
                $errors[] = "idcountry must be number";
            }
        }
        if(!$phone){
            $errors[] = "phone is required";
        }else{
            if(strlen($phone) < 9){
                $errors[] = "minimum phone length is 9";
            }
        }
        if(!$email){
            $errors[] = "email is required";
        }
        if(!$password){
            $errors[] = "password is required";
        }else{
            if(strlen($password) < 6){
                $errors[] = "minimum password length is 6";
            }
        }

        if(isset($errors)){
            return ["statusCode" => 400, "errors" => $errors];
        }

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($idcountry){
            $data['idcountry'] = $idcountry;
        }
        if($phone){
            $data['phone'] = $phone;
        }
        if($email){
            $data['email'] = $email;
        }
        if($password){
            $data['password'] = DB::RAW("SHA1('$password')");
        }
        if($saldo){
            $data['saldo'] = $saldo;
        }
        if($point){
            $data['point'] = $point;
        }

        return $this->model_customer->create($data);
    }
    
    function save($id){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");
        $phone = $this->post("phone");
        $email = $this->post("email");
        $password = $this->post("password");
        $saldo = $this->post("saldo");
        $point = $this->post("point");

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($idcountry){
            $data['idcountry'] = $idcountry;
        }
        if($phone){
            $data['phone'] = $phone;
        }
        if($email){
            $data['email'] = $email;
        }
        if($password){
            $data['password'] = DB::RAW("SHA1('$password')");
        }
        if($saldo){
            $data['saldo'] = $saldo;
        }
        if($point){
            $data['point'] = $point;
        }

        return $this->model_customer->update($id, $data);
    }
    
    function destroy(){
        return $this->get();
    }
}