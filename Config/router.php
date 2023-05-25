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

// Driver
Router::get("/driver", ["DriverController"]);
Router::get("/driver/$", ["DriverController", "show"]);
Router::post("/driver", ["DriverController", "store"]);
Router::post("/driver/$", ["DriverController", "save"]);
Router::delete("/driver/$", ["DriverController", "destroy"]);

// Country
Router::get("/country", ["CountryController"]);
Router::get("/country/$", ["CountryController", "show"]);
Router::post("/country", ["CountryController", "store"]);
Router::post("/country/$", ["CountryController", "save"]);
Router::delete("/country/$", ["CountryController", "destroy"]);

// Region
Router::get("/region", ["RegionController"]);
Router::get("/region/$", ["RegionController", "show"]);
Router::post("/region", ["RegionController", "store"]);
Router::post("/region/$", ["RegionController", "save"]);
Router::delete("/region/$", ["RegionController", "destroy"]);

// City
Router::get("/city", ["CityController"]);
Router::get("/city/$", ["CityController", "show"]);
Router::post("/city", ["CityController", "store"]);
Router::post("/city/$", ["CityController", "save"]);
Router::delete("/city/$", ["CityController", "destroy"]);

// Location
Router::get("/location", ["LocationController"]);
Router::get("/location/$", ["LocationController", "show"]);
Router::post("/location", ["LocationController", "store"]);
Router::post("/location/$", ["LocationController", "save"]);
Router::delete("/location/$", ["LocationController", "destroy"]);
