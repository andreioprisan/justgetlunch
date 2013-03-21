<?php

class Yrestaurantsm extends CI_Model 
{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function getbyid($yid)
	{
		$query = $this->db->get_where('yelp_restaurants', array('yid' => $yid));
		return $query->row();
	}
	
	function update($yid, $data)
	{
		$this->db->where('yid', $uid);
		$this->db->update('yelp_restaurants', $data); 
		return $this->db->insert_id();
	}

	function insert($data)
	{
		$existingrec = 0;
		if (isset($data['yid']))
		{
			$query = $this->db->get_where('yelp_restaurants', array('yid' => $data['yid']) );
			$existingrec = count($query->result());
		}
	
		if ($existingrec == 0) {
			$this->db->insert('yelp_restaurants', $data);
			return $this->db->insert_id();
		} else {
			$this->db->where('yid', $data['yid']);
			$this->db->update('yelp_restaurants', $data); 
			return $this->getbyid($data['yid']);
		}
	}
}
