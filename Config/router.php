<?php
require_once APP_PATH . "/Utils/Router.php";

// App
Router::get("/", ["AppController"]);

// Customer
Router::get("/customer", ["CustomerController"]);
Router::get("/customer/$", ["CustomerController", "show"]);
Router::post("/customer", ["CustomerController", "store"]);
Router::post("/customer/$", ["CustomerController", "save"]);
Router::delete("/customer/$", ["CustomerController", "destroy"]);


// Country
Router::get("/country", ["CountryController"]);
Router::get("/country/$", ["CountryController", "show"]);
Router::post("/country", ["CountryController", "store"]);
Router::post("/country/$", ["CountryController", "save"]);
Router::delete("/country/$", ["CountryController", "destroy"]);

// Driver
Router::get("/driver", ["DriverController"]);
Router::get("/driver/$", ["DriverController", "show"]);
Router::post("/driver", ["DriverController", "store"]);
Router::post("/driver/$", ["DriverController", "save"]);
Router::delete("/driver/$", ["DriverController", "destroy"]);
