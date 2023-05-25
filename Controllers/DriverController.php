<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelDriver.php";

class DriverController extends Controller {
    public function __construct(){
        $this->model_driver = new ModelDriver();
    }
    public function index(){
        return $this->model_driver->get();
    }

    public function show($id){
        return $this->model_driver->getById($id);
    }

    public function store(){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");
        $idcity = $this->post("idcity");
        $phone = $this->post("phone");
        $email = $this->post("email");
        $password = $this->post("password");
        
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
        if(!$idcity){
            $errors[] = "idcity is required";
        }else{
            if(!is_numeric($idcity)){
                $errors[] = "idcity must be number";
            }
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
        if($idcity){
            $data['idcity'] = $idcity;
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

        return $this->model_driver->create($data);
    }
    
    public function save($id){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");
        $idcity = $this->post("idcity");
        $phone = $this->post("phone");
        $email = $this->post("email");
        $password = $this->post("password");

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($idcountry){
            $data['idcountry'] = $idcountry;
        }
        if($idcity){
            $data['idcity'] = $idcity;
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

        return $this->model_driver->update($id, $data);
    }
    
    public function destroy($id){
        return $this->get();
    }
}