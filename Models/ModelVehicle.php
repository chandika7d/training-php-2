<?php
require_once "Model.php";
class ModelVehicle extends Model
{
    protected $table = "vehicle";

    function get()
    {
        $this->db->reset();
        $this->db->select("{$this->table}.id, {$this->table}.date as date, vehiclebrand.id, vehiclebrand.brand as brand, vehiclebrand.name as vehicle_name, ridetype.id as idridetype, ridetype.name as ridetype, {$this->table}.platenumber, driver.id as iddriver, driver.name as driver_name");
        $this->db->join("driver", "driver.id", "{$this->table}.iddriver", "inner");
        $this->db->join("vehiclebrand", "vehiclebrand.id", "{$this->table}.idvehiclebrand", "inner");
        $this->db->join("ridetype", "ridetype.id", "{$this->table}.ridetype", "inner");
        return $this->db->get();
    }
    function getById($id)
    {
        $this->db->reset();        
        $this->db->select("{$this->table}.id, {$this->table}.date as date, vehiclebrand.id, vehiclebrand.brand as brand, vehiclebrand.name as vehicle_name, ridetype.id as idridetype, ridetype.name as ridetype, {$this->table}.platenumber, driver.id as iddriver, driver.name as driver_name");
        $this->db->join("driver", "driver.id", "{$this->table}.iddriver", "inner");
        $this->db->join("vehiclebrand", "vehiclebrand.id", "{$this->table}.idvehiclebrand", "inner");
        $this->db->join("ridetype", "ridetype.id", "{$this->table}.ridetype", "inner");
        $this->db->where("{$this->table}.{$this->primaryKey} = '{$id}'");
        return $this->db->first();
    }

    function create($data)
    {
        $this->db->data($data);
        $id = $this->db->insert();
        if ($id) return $this->getById($id);
        else return false;
    }
    function update($id, array $data)
    {
        $this->db->data($data);
        $this->db->where("{$this->primaryKey} = '$id'");
        if ($this->db->update()) return $this->getById($id);
        else return false;
    }
}