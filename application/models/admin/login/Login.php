<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Model
{
    function insert($tablename,$data)
	{	
		return $this->db->insert($tablename,$data);
	}
	function insertid($tablename,$data)
	{	
		$this->db->insert($tablename,$data);
		$insert_id = $this->db->insert_id();
   		return  $insert_id;
	}
	public function select($select,$condition,$tablename)
	{	                
		$this->db->select($select);
		$this->db->where($condition);
		return $this->db->get($tablename)->result_array();
	}
	public function selects($select,$condition,$tablename)
	{
		$this->db->select($select);
		$this->db->where($condition);
		return $this->db->get($tablename)->row_array();
	}
}
?>
