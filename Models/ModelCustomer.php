<?php
include "Model.php";
class ModelCustomer extends Model
{
    protected $table = "customer";

    function get()
    {
        $this->db->reset();
        $this->db->select("customer.id, customer.name, CONCAT(country.countrycode, customer.phone) as phone, customer.email");
        $this->db->join("country", "country.id", "customer.idcountry", "inner");
        return $this->db->get();
    }
    function getById($id)
    {
        $this->db->reset();
        $this->db->select("customer.id, customer.name, CONCAT(country.countrycode, customer.phone) as phone, customer.email");
        $this->db->join("country", "country.id", "customer.idcountry", "inner");
        $this->db->where("customer.id = {$id}");
        return $this->db->get();
    }

    function create($data)
    {
        $this->db->data($data);
        $id = $this->db->insert();
        if ($id) return $this->getById($id);
        else return false;
    }
}