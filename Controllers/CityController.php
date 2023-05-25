<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelCity.php";

class CityController extends Controller {
    private function __construct(){
        parent::__construct();
        $this->model_city = new ModelCity();
    }
    public function index(){
        return $this->model_city->get();
    }

    public function show($id){
        return $this->model_city->getById($id);
    }

    public function store(){
        $name = $this->post("name");
        $idregion = $this->post("idregion");
        
        $errors = [];
        if(!$name){
            $errors[] = "name is required";
        }
        if(!$idregion){
            $errors[] = "idregion is required";
        }else{
            if(!is_numeric($idregion)){
                $errors[] = "idregion must be number";
            }
        }

        if(isset($errors)){
            return ["statusCode" => 400, "errors" => $errors];
        }

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($idregion){
            $data['idregion'] = $idregion;
        }

        return $this->model_city->create($data);
    }
    
    public function save($id){
        $name = $this->post("name");
        $idregion = $this->post("idregion");

        $data = [];
        
        if($name){
            $data['name'] = $name;
        }
        if($idregion){
            $data['idregion'] = $idregion;
        }

        return $this->model_city->update($id, $data);
    }
    
    public function destroy($id){
        return $this->get();
    }
}