<?php

class Linviteesm extends CI_Model 
{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function getbiid($iid)
	{
		$query = $this->db->get_where('lunch_invitees', array('iid' => $iid));
		return $query->row();
	}
	
	function getbylid_n_author_n_invitee($lid, $uid_author, $uid_invitee)
	{
		$query = $this->db->get_where('lunch_invitees', 
				array(	'lid' 			=> 	$lid,
						'uid_author' 	=> 	$uid_author,
						'uid_invitee'	=>	$uid_invitee
					)
				);
		return $query->row();
	}

	function update($iid, $data)
	{
		$this->db->where('iid', $uid);
		$this->db->update('lunch_invitees', $data); 
		return $this->db->insert_id();
	}

	function insert($data)
	{
		$existingrec = 0;
		if (isset($data['iid']))
		{
			$query = $this->db->get_where('lunch_invitees', array('iid' => $data['iid']) );
			$existingrec = count($query->result());
		} else if (isset($data['lid']) && isset($data['uid_author']) && isset($data['uid_invitee'])) {
			$query = $this->db->get_where('lunch_invitees', 
				array(
					'lid' => $data['lid'],
					'uid_author' => $data['uid_author'],
					'uid_invitee' => $data['uid_invitee'],
					) 
				);
			$existingrec = count($query->result());
		}

		if ($existingrec == 0) {
			$this->db->insert('lunch_invitees', $data);
			return $this->db->insert_id();
		} else {

			if (isset($data['iid']))
			{
				$this->db->where('iid', $data['iid']);
				$this->db->update('lunch_invitees', $data); 
				$a = $this->getbyiid($data['iid']);
				return $a->iid;
			} else if (isset($data['lid']) && isset($data['uid_author']) && isset($data['uid_invitee'])) {
				$this->db->where('lid', $data['lid']);
				$this->db->where('uid_author', $data['uid_author']);
				$this->db->where('uid_invitee', $data['uid_invitee']);
				$this->db->update('lunch_invitees', $data); 
				$a = $this->getbylid_n_author_n_invitee($data['lid'], $data['uid_author'], $data['uid_invitee']);
				return $a->iid;
			}

			return -1;
		}

	}
}
