<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelRideType.php";

class RideTypeController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_ride_type = new ModelRideType();
    }
    function index(){
        return $this->model_ride_type->get();
    }

    function show($id){
        return $this->model_ride_type->getById($id);
    }

    function store(){
        $name = $this->post("name");
        $kmfee = $this->post("kmfee");

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($kmfee){
            $data['kmfee'] = $kmfee;
        }

        return $this->model_ride_type->create($data);
    }
    
    function save($id){
        $name = $this->post("name");
        $kmfee = $this->post("kmfee");

        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($kmfee){
            $data['kmfee'] = $kmfee;
        }

        return $this->model_ride_type->update($id, $data);
    }
    
    function destroy(){
        return $this->get();
    }
}