<?php

class Lunchm extends CI_Model 
{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function getbyid($lid)
	{
		$query = $this->db->get_where('lunches', array('lid' => $lid));
		return $query->row();
	}
	
	function update($lid, $data)
	{
		$this->db->where('lid', $uid);
		$this->db->update('lunches', $data); 
		return $this->db->insert_id();
	}

	function insert($data)
	{
		$existingrec = 0;
		if (isset($data['lid']))
		{
			$query = $this->db->get_where('lunches', array('lid' => $data['lid']) );
			$existingrec = count($query->result());
		}
	
		if ($existingrec == 0) {
			$this->db->insert('lunches', $data);
			return $this->db->insert_id();
		} else {
			$this->db->where('lid', $data['lid']);
			$this->db->update('lunches', $data); 
			$a = $this->getbyid($data['lid']);
			return $a->lid;
		}
	}
}
