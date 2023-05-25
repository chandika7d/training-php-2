<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelCity.php";

class CityController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_city = new ModelCity();
    }
    function index(){
        return $this->model_city->get();
    }

    function show($id){
        return $this->model_city->getById($id);
    }

    function store(){
        $name = $this->post("name");
        $idregion = $this->post("idregion");

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($idregion){
            $data['idregion'] = $idregion;
        }

        return $this->model_city->create($data);
    }
    
    function save($id){
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
    
    function destroy(){
        return $this->get();
    }
}