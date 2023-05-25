<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelRegion.php";

class RegionController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_region = new ModelRegion();
    }
    function index(){
        return $this->model_region->get();
    }

    function show($id){
        return $this->model_region->getById($id);
    }

    function store(){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");

        
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

        return $this->model_region->create($data);
    }
    
    function save($id){
        $name = $this->post("name");
        $idcountry = $this->post("idcountry");

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($idcountry){
            $data['idcountry'] = $idcountry;
        }

        return $this->model_region->update($id, $data);
    }
    
    function destroy(){
        return $this->get();
    }
}