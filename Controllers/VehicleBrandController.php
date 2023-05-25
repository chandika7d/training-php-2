<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelVehicleBrand.php";

class VehicleBrandController extends Controller {
    private function __construct(){
        parent::__construct();
        $this->vehicle_brand = new ModelVehicleBrand();
    }
    public function index(){
        return $this->vehicle_brand->get();
    }

    public function show($id){
        return $this->vehicle_brand->getById($id);
    }

    public function store(){
        $name = $this->post("name");
        $brand = $this->post("brand");

        if(!$name){
            $errors[] = "name is required";
        }
        if(!$brand){
            $errors[] = "brand is required";
        }

        if(isset($errors)){
            return ["statusCode" => 400, "errors" => $errors];
        }

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($brand){
            $data['brand'] = $brand;
        }

        return $this->vehicle_brand->create($data);
    }
    
    public function save($id){
        $name = $this->post("name");
        $brand = $this->post("brand");

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($brand){
            $data['brand'] = $brand;
        }

        return $this->vehicle_brand->update($id, $data);
    }
    
    public function destroy($id){
        return $this->get();
    }
}