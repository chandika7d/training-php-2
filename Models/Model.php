<?php
include_once APP_PATH . "/Utils/DB.php";

class Model{
    protected $db;
    protected $table = "";
    protected $primaryKey = "id";

    public function __construct()
    {
        $this->db = new DB();
        $this->db->table($this->table);
        $this->db->primaryKey($this->primaryKey);
    }

    public function __destruct()
    {
        if ($this->db !== null) {
            $this->db = null;
        }
    }
}
