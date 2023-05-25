<?php
require_once "Model.php";
class ModelRegion extends Model
{
    protected $table = "region";

    function get()
    {
        $this->db->reset();
        $this->db->select("{$this->table}.id, {$this->table}.name, idcountry, country.name as country");
        $this->db->join("country", "country.id", "{$this->table}.idcountry", "inner");
        return $this->db->get();
    }
    function getById($id)
    {
        $this->db->reset();
        $this->db->select("{$this->table}.id, {$this->table}.name, idcountry, country.name as country");
        $this->db->join("country", "country.id", "{$this->table}.idcountry", "inner");
        $this->db->where("{$this->table}.{$this->primaryKey} = '{$id}'");
        return $this->db->get();
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