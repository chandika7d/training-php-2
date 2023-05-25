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
        $countrycode = $this->post("countrycode");

        $errors = [];
        if(!$name){
            $errors[] = "name is required";
        }
        if(!$countrycode){
            $errors[] = "countrycode is required";
        }

        if(isset($errors)){
            return ["statusCode" => 400, "errors" => $errors];
        }

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($countrycode){
            $data['countrycode'] = $countrycode;
        }

        return $this->model_country->create($data);
    }
    
    function save($id){
        $name = $this->post("name");
        $countrycode = $this->post("countrycode");

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($countrycode){
            $data['countrycode'] = $countrycode;
        }

        return $this->model_country->update($id, $data);
    }
    
    function destroy(){
        return $this->get();
    }
}