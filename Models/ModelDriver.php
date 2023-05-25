<?php
require_once "Model.php";
class ModelDriver extends Model
{
    protected $table = "driver";

    function get()
    {
        $this->db->reset();
        $this->db->select("driver.id, driver.name, CONCAT(country.countrycode, driver.phone) as phone, driver.email, city.name as city");
        $this->db->join("country", "country.id", "driver.idcountry", "inner");
        $this->db->join("city", "city.id", "driver.idcity", "inner");
        return $this->db->get();
    }
    function getById($id)
    {
        $this->db->reset();
        $this->db->select("driver.id, driver.name, CONCAT(country.countrycode, driver.phone) as phone, driver.email, city.name as city");
        $this->db->join("country", "country.id", "driver.idcountry", "inner");
        $this->db->join("city", "city.id", "driver.idcity", "inner");
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