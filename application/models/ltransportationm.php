<?php

class Ltransportationm extends CI_Model 
{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function getbytid($tid)
	{
		$query = $this->db->get_where('lunch_transportation', array('tid' => $tid));
		return $query->row();
	}
	
	function getbylid_n_author($lid, $uid_author)
	{
		$query = $this->db->get_where('lunch_transportation', 
				array(	'lid'		 => $lid,
						'uid_author' => $uid_author
					)
				);
		return $query->row();
	}
	
	function update($tid, $data)
	{
		$this->db->where('tid', $tid);
		$this->db->update('lunch_transportation', $data); 
		return $this->db->insert_id();
	}

	function insert($data)
	{
		$existingrec = 0;
		if (isset($data['tid']))
		{
			$query = $this->db->get_where('lunch_transportation', array('tid' => $data['tid']) );
			$existingrec = count($query->result());
		} else if (isset($data['lid']) && isset($data['uid_author'])) {
			$query = $this->db->get_where('lunch_transportation', 
				array(
					'lid' => $data['lid'],
					'uid_author' => $data['uid_author']
					) );
			$existingrec = count($query->result());
		}
	
		if ($existingrec == 0) {
			$this->db->insert('lunch_transportation', $data);
			return $this->db->insert_id();
		} else {

			if (isset($data['tid']))
			{
				$this->db->where('tid', $data['tid']);
				$this->db->update('lunch_transportation', $data); 
				$a = $this->getbytid($data['tid']);
				return $a->tid;
			} else if (isset($data['lid']) && isset($data['uid_author'])) {
				$this->db->where('lid', $data['lid']);
				$this->db->where('uid_author', $data['uid_author']);
				$this->db->update('lunch_transportation', $data); 
				$a = $this->getbylid_n_author($data['lid'], $data['uid_author']);
				return $a->tid;
			}

			return -1;
		}
	}
}
