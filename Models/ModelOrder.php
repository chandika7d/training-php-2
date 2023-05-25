<?php
require_once "Model.php";
class ModelOrder extends Model
{
    protected $table = "`order`";

    public function get()
    {
        $this->db->reset();
        $this->db->select("{$this->table}.id, {$this->table}.orderdate, {$this->table}.idcustomer, {$this->table}.iddriver, {$this->table}.idvehicle, {$this->table}.distance, {$this->table}.pickupdate, {$this->table}.idpickup, {$this->table}.dropdate, {$this->table}.iddrop, {$this->table}.appservicefee, {$this->table}.tripfare, {$this->table}.discount, ({$this->table}.appservicefee + {$this->table}.tripfare - {$this->table}.discount) as total");
        return $this->db->get();
    }
    public function getById($id)
    {
        $this->db->reset();
        $this->db->select("{$this->table}.id, {$this->table}.orderdate, {$this->table}.idcustomer, {$this->table}.iddriver, {$this->table}.idvehicle, {$this->table}.distance, {$this->table}.pickupdate, {$this->table}.idpickup, {$this->table}.dropdate, {$this->table}.iddrop, {$this->table}.appservicefee, {$this->table}.tripfare, {$this->table}.discount, ({$this->table}.appservicefee + {$this->table}.tripfare - {$this->table}.discount) as total");
        return $this->db->first();
    }

    public function create($data)
    {
        $this->db->data($data);
        $this->db->insert();
        return $this->getById($data['id']);
    }

    public function update($id, array $data)
    {
        $this->db->data($data);
        $this->db->where("{$this->primaryKey} = '$id'");
        if ($this->db->update()) return $this->getById($id);
        else return false;
    }
}