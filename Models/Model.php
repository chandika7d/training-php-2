<?php
include "./Utils/DB.php";
class Model
{
    protected $db;
    protected $table = "";
    protected $primaryKey = "id";

    function __construct()
    {
        $this->db = new DB();
        $this->db->table($this->table);
        $this->db->primaryKey($this->primaryKey);
    }

    function __destruct()
    {
        if ($this->db !== null) {
            $this->db = null;
        }
    }
}