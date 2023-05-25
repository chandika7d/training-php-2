<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelLocation.php";

class LocationController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_country = new ModelLocation();
    }
    function index(){
        return $this->model_country->get();
    }

    function show($id){
        return $this->model_country->getById($id);
    }

    function store(){
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

        return $this->model_country->create($data);
    }
    
    function save($id){
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
    
    function destroy(){
        return $this->get();
    }
}