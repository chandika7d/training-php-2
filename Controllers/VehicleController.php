<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelVehicle.php";

class VehicleController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_vehicle = new ModelVehicle();
    }
    function index(){
        return $this->model_vehicle->get();
    }

    function show($id){
        return $this->model_vehicle->getById($id);
    }

    function store(){
        $iddriver = $this->post("iddriver");
        $ridetype = $this->post("ridetype");
        $idvehiclebrand = $this->post("idvehiclebrand");
        $platenumber = $this->post("platenumber");
        $date = DB::RAW("NOW()");

        
        if(!$iddriver){
            $errors[] = "iddriver is required";
        }else{
            if(!is_numeric($iddriver)){
                $errors[] = "iddriver must be number";
            }
        }
        if(!$ridetype){
            $errors[] = "ridetype is required";
        }else{
            if(!is_numeric($ridetype)){
                $errors[] = "ridetype must be number";
            }
        }
        if(!$idvehiclebrand){
            $errors[] = "idvehiclebrand is required";
        }else{
            if(!is_numeric($idvehiclebrand)){
                $errors[] = "idvehiclebrand must be number";
            }
        }
        if(!$platenumber){
            $errors[] = "platenumber is required";
        }

        if(isset($errors)){
            return ["statusCode" => 400, "errors" => $errors];
        }

        $data = [];
        if($iddriver){
            $data['iddriver'] = $iddriver;
        }
        if($ridetype){
            $data['ridetype'] = $ridetype;
        }
        if($idvehiclebrand){
            $data['idvehiclebrand'] = $idvehiclebrand;
        }
        if($platenumber){
            $data['platenumber'] = $platenumber;
        }
        if($date){
            $data['date'] = $date;
        }

        return $this->model_vehicle->create($data);
    }
    
    function save($id){
        $iddriver = $this->post("iddriver");
        $ridetype = $this->post("ridetype");
        $idvehiclebrand = $this->post("idvehiclebrand");
        $platenumber = $this->post("platenumber");

        $data = [];
        if($iddriver){
            $data['iddriver'] = $iddriver;
        }
        if($ridetype){
            $data['ridetype'] = $ridetype;
        }
        if($idvehiclebrand){
            $data['idvehiclebrand'] = $idvehiclebrand;
        }
        if($platenumber){
            $data['platenumber'] = $platenumber;
        }

        return $this->model_vehicle->update($id, $data);
    }
    
    function destroy(){
        return $this->get();
    }
}