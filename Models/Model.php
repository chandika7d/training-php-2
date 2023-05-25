<?php
include_once APP_PATH . "/Utils/DB.php";
class Model
{
    protected $db;
    protected $table = "";
    protected $primaryKey = "id";

    private function __construct()
    {
        $this->db = new DB();
        $this->db->table($this->table);
        $this->db->primaryKey($this->primaryKey);
    }

    private function __destruct()
    {
        if ($this->db !== null) {
            $this->db = null;
        }
    }
}