<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelDriver.php";

class DriverController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_driver = new ModelDriver();
    }
    function index(){
        return $this->model_driver->get();
    }

    function show($id){
        return $this->model_driver->getById($id);
    }

    function store(){
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

        return $this->model_driver->create($data);
    }
    
    function save($id){
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
    
    function destroy(){
        return $this->get();
    }
}