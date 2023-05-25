<?php
require_once "Model.php";
class ModelCustomer extends Model
{
    protected $table = "customer";

    public function get()
    {
        $this->db->reset();
        $this->db->select("{$this->table}.id, {$this->table}.name, CONCAT(country.countrycode, {$this->table}.phone) as phone, {$this->table}.email, {$this->table}.saldo, {$this->table}.point");
        $this->db->join("country", "country.id", "{$this->table}.idcountry", "inner");
        return $this->db->get();
    }
    public function getById($id)
    {
        $this->db->reset();
        $this->db->select("{$this->table}.id, {$this->table}.name, CONCAT(country.countrycode, {$this->table}.phone) as phone, {$this->table}.email, {$this->table}.saldo, {$this->table}.point");
        $this->db->join("country", "country.id", "{$this->table}.idcountry", "inner");
        $this->db->where("{$this->table}.{$this->primaryKey} = '{$id}'");
        return $this->db->first();
    }

    public function create($data)
    {
        $this->db->data($data);
        $id = $this->db->insert();
        if ($id) return $this->getById($id);
        else return false;
    }
    public function update($id, array $data)
    {
        $this->db->data($data);
        $this->db->where("{$this->primaryKey} = '$id'");
        if ($this->db->update()) return $this->getById($id);
        else return false;
    }
}