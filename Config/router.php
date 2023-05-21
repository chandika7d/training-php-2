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
