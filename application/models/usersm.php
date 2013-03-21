<?php

class Usersm extends CI_Model 
{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function getuid($googleid)
	{
		$query = $this->db->get_where('users', array('googleid' => $googleid));
		return $query->row()->uid;
	}
	
	function getid($ufid)
	{
		$query = $this->db->get_where('users', array('ufid' => $ufid));
		return $query->row();
	}

	function getbyid($uid)
	{
		$query = $this->db->get_where('users', array('uid' => $uid));
		return $query->row();
	}

	function getbyemail($email)
	{
		$query = $this->db->get_where('users', array('email' => $email));
		return $query->row();
	}
	
	function update($uid, $data)
	{
		$this->db->where('uid', $uid);
		$this->db->update('users', $data); 
		return $this->db->insert_id();
	}

	function insert($data)
	{
		$existingrec = 0;
		if (isset($data['googleid']) || isset($data['email']))
		{
			if (isset($data['googleid']))
			{
				$query = $this->db->get_where('users', array('googleid' => $data['googleid']) );
			} else if (isset($data['email'])) {
				$query = $this->db->get_where('users', array('email' => $data['email']) );
			}
			$existingrec = count($query->result());
		}
	
		if ($existingrec == 0) {
			$this->db->insert('users', $data);
			return $this->db->insert_id();
		} else {
			if (isset($data['googleid']))
			{
				$this->db->where('googleid', $data['googleid']);
			} else if (isset($data['email'])) {
				$this->db->where('email', $data['email']);
			}

			$this->db->update('users', $data); 
			$a = $this->getbyemail($data['email']);
			return $a->uid;
		}
	}
}
