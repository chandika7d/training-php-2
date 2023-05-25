<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelCountry.php";

class CountryController extends Controller {
    private function __construct(){
        $this->model_country = new ModelCountry();
    }
    public function index(){
        return $this->model_country->get();
    }

    public function show($id){
        return $this->model_country->getById($id);
    }

    public function store(){
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
    
    public function save($id){
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
    
    public function destroy($id){
        return $this->get();
    }
}