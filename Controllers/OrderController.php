<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelOrder.php";
require_once APP_PATH . "/Models/ModelDriver.php";
require_once APP_PATH . "/Models/ModelCustomer.php";
require_once APP_PATH . "/Models/ModelVehicle.php";
require_once APP_PATH . "/Models/ModelLocation.php";

class OrderController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_order = new ModelOrder();
        $this->model_driver = new ModelDriver();
        $this->model_customer = new ModelCustomer();
        $this->model_vechile = new ModelVehicle();
        $this->model_location = new ModelLocation();
    }
    function index(){
        $orders = $this->model_order->get();
        $orders = array_map("self::addAttribute", $orders);
        return $orders;
    }

    function show($id){
        $order = $this->model_order->getById($id);
        $order = $this->addAttribute($order);
        return $order;
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

        return $this->model_order->create($data);
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

        return $this->model_order->update($id, $data);
    }
    
    function destroy(){
        return $this->get();
    }

    function addAttribute($order){
        $driver = $this->model_driver->getById($order['iddriver']);
        $customer = $this->model_customer->getById($order['idcustomer']);
        $vechile = $this->model_vechile->getById($order['idvehicle']);
        $pickup = $this->model_location->getById($order['idpickup']);
        $drop = $this->model_location->getById($order['iddrop']);
        $pickup['pickupdate'] = $order["pickupdate"];
        $drop['dropdate'] = $order["dropdate"];
        
        $order['driver'] = $driver;
        $order['customer'] = $customer;
        $order['vechile'] = $vechile;
        $order['pickup'] = $pickup;
        $order['drop'] = $drop;

        unset($order["pickupdate"]);
        unset($order["dropdate"]);
        unset($order["idcustomer"]);
        unset($order["iddriver"]);
        unset($order["idvehicle"]);
        unset($order["idpickup"]);
        unset($order["iddrop"]);

        return $order;
    }
}