<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelLocation.php";

class LocationController extends Controller {
    private function __construct(){
        parent::__construct();
        $this->model_country = new ModelLocation();
    }
    public function index(){
        return $this->model_country->get();
    }

    public function show($id){
        return $this->model_country->getById($id);
    }

    public function store(){
        $addressname = $this->post("addressname");
        $address = $this->post("address");
        $lat = $this->post("lat");
        $lon = $this->post("lon");
        
        if(!$addressname){
            $errors[] = "addressname is required";
        }
        if(!$address){
            $errors[] = "address is required";
        }
        if(!$lat){
            $errors[] = "lat is required";
        }
        if(!$lon){
            $errors[] = "lon is required";
        }

        if(isset($errors)){
            return ["statusCode" => 400, "errors" => $errors];
        }

        $data = [];
        if($addressname){
            $data['addressname'] = $addressname;
        }
        if($address){
            $data['address'] = $address;
        }
        if($lat){
            $data['lat'] = $lat;
        }else{
            if(!is_numeric($lat)){
                $errors[] = "lat must be number";
            }
        }
        if($lon){
            $data['lon'] = $lon;
        }else{
            if(!is_numeric($lon)){
                $errors[] = "lon must be number";
            }
        }

        return $this->model_country->create($data);
    }
    
    public function save($id){
        $addressname = $this->post("addressname");
        $address = $this->post("address");
        $lat = $this->post("lat");
        $lon = $this->post("lon");

        $data = [];
        if($addressname){
            $data['addressname'] = $addressname;
        }
        if($address){
            $data['address'] = $address;
        }
        if($lat){
            $data['lat'] = $lat;
        }
        if($lon){
            $data['lon'] = $lon;
        }

        return $this->model_country->update($id, $data);
    }
    
    public function destroy($id){
        return $this->get();
    }
}