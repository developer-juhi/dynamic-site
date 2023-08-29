<?php
class Comman_model extends CI_Model
{
    public function __construct(){
        parent::__construct();  

    }

    public function insert($table,$data)
    {
        return $this->db->insert($table,$data);
    }

    public function selects($select,$condition,$tablename)
    {
		$this->db->select($select);
		$this->db->where($condition);
		return $this->db->get($tablename)->result_array();
    }

    public function select($select,$condition,$tablename)
    {
		$this->db->select($select);
		$this->db->where($condition);
		return $this->db->get($tablename)->row_array();
    }
    
    public function display($tbl)
    {
        return $this->db->get($tbl)->result_array();
    }

    public function display_images($tbl)
    {
        $this->db->where('status','0');
        return $this->db->get($tbl)->result_array();
    }

    public function displayData($tbl)
    {
        $r=$this->db->get($tbl);
        return $r->result();
    }
    
    public function edit_model($tbl,$col,$val)
    {      
        $this->db->where($col,$val);
        $r=$this->db->get($tbl);
        return $r->result_array();
    }

    public function update_record($table,$condition,$data)
    {
        $this->db->where($condition);
        return $this->db->update($table,$data);      
    }

   
}
?>