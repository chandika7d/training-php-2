<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelCountry.php";

class CountryController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_country = new ModelCountry();
    }
    function index(){
        return $this->model_country->get();
    }

    function show($id){
        return $this->model_country->getById($id);
    }

    function store(){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");
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
        if($phone){
            $data['phone'] = $phone;
        }
        if($email){
            $data['email'] = $email;
        }
        if($password){
            $data['password'] = DB::RAW("SHA1('$password')");
        }

        return $this->model_country->create($data);
    }
    
    function save($id){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");
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
        if($phone){
            $data['phone'] = $phone;
        }
        if($email){
            $data['email'] = $email;
        }
        if($password){
            $data['password'] = DB::RAW("SHA1('$password')");
        }

        return $this->model_country->update($id, $data);
    }
    
    function destroy(){
        return $this->get();
    }
}