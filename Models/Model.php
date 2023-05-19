<?php
include "./Config/database.php";
class Model
{
    public $error = "";
    private $driver = null;
    function __construct()
    {
        $this->driver = new mysqli('127.0.0.1', 'root', 'password', 'gocar2');
        if ($this->driver->connect_error) {
            die("Koneksi Gagal: " . $this->driver->connect_error);
        }
    }

    function __destruct()
    {
        if ($this->driver !== null) {
            $this->driver = null;
        }
    }

    function select($query)
    {
        $data = mysqli_query($this->driver, $query);
        return mysqli_fetch_assoc($data);
    }
}