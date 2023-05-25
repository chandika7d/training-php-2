<?php
require_once "Controller.php";
require_once APP_PATH . "/Models/ModelOrder.php";
require_once APP_PATH . "/Models/ModelDriver.php";
require_once APP_PATH . "/Models/ModelCustomer.php";
require_once APP_PATH . "/Models/ModelVehicle.php";
require_once APP_PATH . "/Models/ModelLocation.php";
require_once APP_PATH . "/Models/ModelRideType.php";

class OrderController extends Controller {
    function __construct(){
        parent::__construct();
        $this->model_order = new ModelOrder();
        $this->model_driver = new ModelDriver();
        $this->model_customer = new ModelCustomer();
        $this->model_vehicle = new ModelVehicle();
        $this->model_location = new ModelLocation();
        $this->model_ride_type = new ModelRideType();
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
        $orderdate = DB::RAW("NOW()");
        $idcustomer = $this->post("idcustomer");
        $iddriver = $this->post("iddriver");
        $idvehicle = $this->post("idvehicle");
        $distance = $this->post("distance");
        $pickup = $this->post("pickup");
        $drop = $this->post("drop");
        $appservicefee = $this->post("appservicefee");
        $discount = $this->post("discount");

        $errors = [];
        if(!$orderdate){
            $errors[] = "orderdate is required";
        }
        if(!$idcustomer){
            $errors[] = "idcustomer is required";
        }else{
            if(!is_numeric($idcustomer)){
                $errors[] = "idcustomer must be number";
            }
        }
        if(!$iddriver){
            $errors[] = "iddriver is required";
        }else{
            if(!is_numeric($iddriver)){
                $errors[] = "iddriver must be number";
            }
        }
        if(!$idvehicle){
            $errors[] = "idvehicle is required";
        }else{
            if(!is_numeric($idvehicle)){
                $errors[] = "idvehicle must be number";
            }
        }
        if(!$distance){
            $errors[] = "distance is required";
        }else{
            if(!is_numeric($distance)){
                $errors[] = "distance must be number";
            }
        }
        if(!$pickup){
            $errors[] = "pickup is required";
        }
        if(!$drop){
            $errors[] = "drop is required";
        }
        if(!$appservicefee){
            $errors[] = "appservicefee is required";
        }
        if(!$discount){
            $errors[] = "discount is required";
        }

        if(isset($errors)){
            return ["statusCode" => 400, "errors" => $errors];
        }

        $vehicle = $this->model_vehicle->getById($idvehicle);

        $id = $this->generateIdOrder($vehicle, $idcustomer, $iddriver);

        if(!isset($pickup['id'])){
            $pickup = $this->model_location->create([
                "addressname" => $pickup["addressname"],
                "address" => $pickup["address"],
                "lat" => $pickup["lat"],
                "lon" => $pickup["lon"],
            ]);
        }
        
        if(!isset($drop['id'])){
            $drop = $this->model_location->create([
                "addressname" => $drop["addressname"],
                "address" => $drop["address"],
                "lat" => $drop["lat"],
                "lon" => $drop["lon"],
            ]);
        }

        $data = [
            "id" => $id,
            "orderdate" => $orderdate,
            "idcustomer" => $idcustomer,
            "iddriver" => $iddriver,
            "idvehicle" => $idvehicle,
            "distance" => $distance,
            "appservicefee" => $appservicefee,
            "tripfare" => ((int) $vehicle["kmfee"]) * $distance,
            "discount" => $discount,
            "idpickup" => $pickup["id"],
            "iddrop" => $drop["id"],
        ];

        return $this->model_order->create($data);
    }
    
    function pickup($id){
        $date = DB::RAW("NOW()");

        $data = [
            "pickupdate" => $date
        ];

        return $this->model_order->update($id, $data);
    }
    
    function drop($id){
        $date = DB::RAW("NOW()");

        $data = [
            "dropdate" => $date
        ];

        return $this->model_order->update($id, $data);
    }

    function destroy(){
        return $this->get();
    }

    function addAttribute($order){
        $driver = $this->model_driver->getById($order['iddriver']);
        $customer = $this->model_customer->getById($order['idcustomer']);
        $vechile = $this->model_vehicle->getById($order['idvehicle']);
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

    function generateIdOrder($vehicle, $idcustomer, $iddriver){
        // RB-137786-24-20824
        $vehicleCode = preg_replace('/[^A-Z]/', "", $vehicle['ridetype']);
        $date = date("Ymd");
        $idorder = $vehicleCode . "-" . $date . "-". $idcustomer . $iddriver;
        return  $idorder;
    }
}