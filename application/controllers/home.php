<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('SPARKPATH', getcwd()."/sparks/");
require_once SPARKPATH . "GoogleAPIClient/0.5.0/src/apiClient.php";
require_once SPARKPATH . "GoogleAPIClient/0.5.0/src/contrib/apiCalendarService.php";
require_once SPARKPATH . "GoogleAPIClient/0.5.0/src/contrib/apiOauth2Service.php";

class Home extends CI_Controller {
	var $apiClient;
	var $client = "abc";
	var $oauth2;
	var $oauth_access_token;

	var $userdata;
	var $step;
	var $uid;
	var $poid;
	var $pouid;
	var $author_email;
	var $contacts;

	public function __construct()
	{
		parent::__construct();

		$this->load->library("Googleapps");
		
		if (isset($_SERVER['HTTP_ORIGIN']) && 
			$_SERVER['HTTP_ORIGIN'] == "https://accounts.google.com" &&
			$_SERVER['PHP_SELF'] == "/index.php/home/logout")
		{
			$this->googleapps->logout();
			header("Location: https://www.justgetlunch.com");
			return;			
		} else if ($_SERVER['PHP_SELF'] == "/index.php/home/logout") {
			$this->googleapps->logout();
			header("Location: https://www.justgetlunch.com");
			return;			
		}
			//header("Location: http://www.justgetlunch.com");

		$userData = $this->googleapps->init();


//		$this->load->model('filesm');
//		$this->load->model('posm');
		$this->load->model('usersm');
		
		$this->userdata = $userData;
		$this->insertAuthorData();
//				$this->userdata = $this->session->userdata('userdata');

		/*
		$this->contacts = $this->googleapps->getContacts();
		ksort($this->contacts);
		*/
		
		$this->author_email = strtolower($this->userdata['email']);
		
		$this->session->set_userdata('author_email', $this->author_email);
		$this->session->set_userdata('userdata', $this->userdata);
		$this->session->set_userdata('uid', $this->uid);
		
	}
	
	public function logout()
	{
		unset($_SESSION['access_token']);
		$this->googleapps->logout("https://www.justgetlunch.com");
//		header("Location: http://www.justgetlunch.com");


/*
		if (isset($_SERVER['HTTP_ORIGIN']) &&
			$_SERVER['HTTP_ORIGIN'] == "https://accounts.google.com" &&
			$_SERVER['PHP_SELF'] == "/indefx.php/home/logout")
			header("Location: http://www.justgetlunch.com");
		else {
		}
*/
	}
	
	public function insertAuthorData()
	{
		$userdata = array(
			'googleid'			=>		$this->userdata['id'],
			'given_name'		=>		$this->userdata['given_name'],
			'family_name'		=>		$this->userdata['family_name'],
			'name'				=>		$this->userdata['name'],
			'email'				=>		strtolower($this->userdata['email']),
		);
		
		$this->uid = $this->usersm->insert($userdata);
	}
	
	
	public function index()
	{
//		$a = $this->googleapps->getContacts();
//		var_dump($a);

		$this->load->library('template');
		$this->template->write('title', 'home');
		
		$payload['menu'] = array(	
									array('name' => "Home", 'val' => "/home", 'align' => 'right'),
									array('name' => "Lunch Plans", 'val' => "/plans", 'align' => 'right'),
									array('name' => "Reviews", 'val' => "/reviews", 'align' => 'right'),
									array('name' => "Buddies", 'val' => "/buddies", 'align' => 'right'),
									array('name' => "Restaurants", 'val' => "/restaurants", 'align' => 'right'),
									array('name' => $this->userdata['name'], 'val' => array(	
										array('name' => "Log out", 'val' => "/home/logout"),
									), 'align' => 'right'),
								);

		$payload['css'] = array(	"prettify", 
									"bootstrap.min",
									"bootstrap-responsive.min",
									"font-awesome",
									"apignite",
									"datepicker",
									"chosen",
									"jquery.timepicker",
									);
		$payload['js'] = array(	"jquery-1.7.min", 
								"jquery.tablesorter", 
								"jquery.timepicker.min",
								"chosen.jquery.min",
								"bootstrap.min",
								"application",
								"prettify",
								"bootstrap-datepicker",
								"bootstrap-tab",
								);

		$payload['contactsSelector'] = $this->contacts();
		$payload['userdata'] = $this->userdata;
		$this->template->write_view('content', 'layouts/dashboard', $payload);

		return $this->template->render();
	}


	public function contacts()
	{
		$this->googleapps->init();
		$this->contacts = $this->googleapps->getContacts();
		ksort($this->contacts);
				
		$a = "";
		foreach($this->contacts as $contact => $cdata)
		{
			if (!isset($cdata['email']))
				continue;
			
//			$a .= "<option value='".$cdata['email']."'>".$contact." (".$cdata['email'].")</option>";
			$a .= "<option value='".$cdata['email']."'>".$contact."</option>";
		}

		
		return $a;
	}


}
