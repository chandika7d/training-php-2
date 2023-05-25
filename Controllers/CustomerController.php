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