<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common extends CI_Model
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
		//$this->db2->insert('test',$condition);
		$this->db->select($select);
		$this->db->where($condition);
		return $this->db->get($tablename)->result_array();
	}


	public function selects($select,$condition,$tablename)
	{
		//	$this->db2->insert('test',$condition);
		$this->db->select($select);
		$this->db->where($condition);
		return $this->db->get($tablename)->row_array();
    }
    
    public function _get_datatables_query($table,$column_order,$column_search,$order)
	{ 
		$this->db->from($table); 
		$i = 0;
		
		foreach ($column_search as $item) // loop column 
		{
			// print_r($_POST['search']['value']);die;
			
			if($_POST['search']['value']) // if datatable send POST for search
			{ 
				if($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				} 
			
				if(count($column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
				}
				$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($order)){
			$order = $order;
			$this->db->order_by(key($order), $order[key($order)]);
		} 
	}

	function get_datatables($table,$column_order,$column_search,$order,$condition)
	{
		$this->_get_datatables_query($table,$column_order,$column_search,$order);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->where($condition);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($table,$column_order,$column_search,$order,$condition)
	{
		$this->_get_datatables_query($table,$column_order,$column_search,$order);
		$this->db->where($condition);
		$query = $this->db->get();
		return $query->num_rows();
	} 
	
	public function count_all($table,$column_order,$column_search,$order,$condition)
	{
		$this->db->where($condition);
		$this->db->from($table);
		return $this->db->count_all_results();
	}


	public function deletes($condition,$data,$tablename)
	{		
		$this->db->where($condition);
		return $this->db->update($tablename,$data);
	}

	public function update($condition,$data,$tablename)
	{		
		$this->db->where($condition);
		return $this->db->update($tablename,$data);
	}

	public function deleted($condition,$tablename)
	{		
		$this->db->where($condition);
		return $this->db->delete($tablename);
	}

	public function project_dtls()
	{
		$this->db->select('p.*,pc.*');
		$this->db->from('project p');
		$this->db->join('projectCategory pc','pc.project_category_id = p.project_category_id','left');
		$this->db->where('p.status',0);
		$query=$this->db->get();
		
		return $query->result_array();
	}

	public function project()
	{
		$this->db->distinct();
		$this->db->group_by('project_id');
		$this->db->order_by('project_id','desc');
		$this->db->select('*');
		$this->db->from('project');
		$this->db->limit(3,1);

		$sql= $this->db->get();
		return $sql->result_array();
	}	

}
?>
