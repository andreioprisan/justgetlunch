<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('SPARKPATH', getcwd()."/sparks/");
require_once SPARKPATH . "GoogleAPIClient/0.5.0/src/apiClient.php";
require_once SPARKPATH . "GoogleAPIClient/0.5.0/src/contrib/apiCalendarService.php";
require_once SPARKPATH . "GoogleAPIClient/0.5.0/src/contrib/apiOauth2Service.php";

class Lunch extends CI_Controller {
	var $apiClient;
	var $client = "abc";
	var $oauth2;
	var $oauth_access_token;
	var $userdata;
	var $step;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library("Googleapps");
		$this->load->model('usersm');
		$this->load->model('lunchm');
		$this->load->model('yrestaurantsm');
		$this->load->model('linviteesm');
		$this->load->model('ltransportationm');

		$userData = $this->googleapps->init();
		$this->userdata = $userData;
		$this->contacts = $this->googleapps->getContacts();
		ksort($this->contacts);

		$this->insertAuthorData();
		$this->session->set_userdata('userdata', $this->userdata);
		$this->session->set_userdata('uid', $this->uid);

		$this->menu = array(	
									array('name' => "Home", 'val' => "/home", 'align' => 'right'),
									array('name' => "Lunch Plans", 'val' => "/lunch", 'align' => 'right'),
									array('name' => "Reviews", 'val' => "/reviews", 'align' => 'right'),
									array('name' => "Buddies", 'val' => "/buddies", 'align' => 'right'),
									array('name' => "Restaurants", 'val' => "/restaurants", 'align' => 'right'),
									array('name' => $this->userdata['name'], 'val' => array(	
										array('name' => "Log out", 'val' => "/home/logout"),
									), 'align' => 'right'),
								);

		$this->css 	= array(	"prettify", 
								"bootstrap.min",
								"bootstrap-responsive.min",
								"font-awesome",
								"apignite",
								"datepicker",
								"chosen",
								"jquery.timepicker",
								);
		$this->js 	= array(	"jquery-1.7.min", 
								"jquery.tablesorter", 
								"jquery.timepicker.min",
								"chosen.jquery.min",
								"bootstrap.min",
								"application",
								"prettify",
								"bootstrap-datepicker",
								"bootstrap-tab",
								);
		


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

	function passthrough()
	{
		if (!isset($_POST['url']))
			$url = $_GET['url'];
		else
			$url = $_POST['url'];

//			https://api.yelp.com/business_review_search?callback=&limit=10&term=bbq&location=Boston,%20Massachusetts&ywsid=Ze_vqFmEafbRHhmdPcEZ2g
//		if (!preg_match('/http:/', $url))
//			$url="http://".$_SERVER['SERVER_NAME'].$url;

		//open connection
		$ch = curl_init();

		echo $url;
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

//		echo($result);

	}

	function yelp()
	{
		$term = $_GET['term'];
		$location = $_GET['location'];

		$ch = curl_init();

		$ywsid = "Ze_vqFmEafbRHhmdPcEZ2g";
		$url = "https://api.yelp.com/business_review_search?limit=30&term=".urlencode($term)."&location=".urlencode($location)."&ywsid=".$ywsid;
//		$url = "https://api.yelp.com/v2/search?limit=15&term=".urlencode($term)."&location=".urlencode($location)."&ywsid=".$ywsid;
				//$url = urlencode($url);

		header('Content-type: application/json');

		curl_setopt($ch,CURLOPT_URL,$url);

		//execute post
		
		$result = curl_exec($ch);

		//close connection

		curl_close($ch);

//		echo($result);

	}

	function save()
	{
//		var_dump($_POST);

		$restaurant = array(
			'yid'		=>	$_POST['placeYID'],
			'name'		=>	$_POST['placeName'],
			'address'	=>	$_POST['placeAddress'],
			'phone'		=>	$_POST['placePhone'],
			'url'		=>	$_POST['url'],	
		);

		$this->yrestaurantsm->insert($restaurant);

		$inviteesList = array();

		foreach ($_POST['invitees'] as $i => $iu)
		{
			$sp = explode(" (", $iu);
			$u_email = explode(")", $sp[1]);
			$na = explode(" ", ucwords(strtolower($sp[0])));
			$na_last = count($na);

			$invited_user = array(
				'given_name'	=>	$na[0],
				'family_name'	=>	$na[$na_last-1],
				'name'			=>	ucwords(strtolower($sp[0])),
				'email'			=>	$u_email[0]
			);

			$uid = $this->usersm->insert($invited_user);

			$inviteesList[$uid] = array(	'email'	=>	$invited_user['email'],
											'name'	=>	$invited_user['name']);
		}

		$lunchEntry = array(
			'uid_author'			=>	$this->uid,
			'date'					=>	$_POST['date'],
			'time'					=>	$_POST['time'],
			'near'					=>	$_POST['near'],
			'yid'					=>	$_POST['placeYID'],
			'notes'					=>	$_POST['notes']
		);

		if (isset($_POST['lid']) && $_POST['lid'] != "-1")
			$lunchEntry['lid'] = $_POST['lid'];

		$lid = $this->lunchm->insert($lunchEntry);



		// now save all invited people and notify
		foreach ($inviteesList as $inviteeID => $inviteeInfo)
		{
			$inviteeData = array(
				'lid'			=>	$lid,
				'uid_author'	=>	$this->uid,
				'uid_invitee'	=>	$inviteeID,
				'invitedat'		=>	date('m/d/y H:i:s'),
				'lastupdated'		=>	date('Y-m-d H:i:s')
			);
			$this->linviteesm->insert($inviteeData);
		}

		// save your transportation invitation abilities
		$transportationData = array(
			'lid'			=>	$lid,
			'uid_author'	=>	$this->uid,
			'text'			=>	 $_POST['transportation']
		);

		$this->ltransportationm->insert($transportationData);


		header('Content-type: application/json');

		echo json_encode(array('lid' => $lid));
//		var_dump($lunchEntry);

	}

	function yelp2()
	{
		// Enter the path that the oauth library is in relation to the php file
		require_once (getcwd().'lib/OAuth.php');

		$unsigned_url = "http://api.yelp.com/v2/search?term=tacos&location=sf";


		// Set your keys here
		$consumer_key = "";
		$consumer_secret = "";
		$token = "";
		$token_secret = "";

		// Token object built using the OAuth library
		$token = new OAuthToken($token, $token_secret);

		// Consumer object built using the OAuth library
		$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

		// Yelp uses HMAC SHA1 encoding
		$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

		// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
		$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

		// Sign the request
		$oauthrequest->sign_request($signature_method, $consumer, $token);

		// Get the signed URL
		$signed_url = $oauthrequest->to_url();

		// Send Yelp API Call
		$ch = curl_init($signed_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch); // Yelp response
		curl_close($ch);

		// Handle Yelp response data
		$response = json_decode($data);

		// Print it for debugging
		print_r($response);

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
			$a .= "<option value='".$contact." (".$cdata['email'].")'>".$contact."</option>";
		}
		
		return $a;
	}

	public function geoip()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if ($ip == "127.0.0.1")
			$ip = "50.133.180.144";

		$url = "http://api.easyjquery.com/ips/?ip=".$ip."&full=true";

		// remember chmod 0777 for folder 'cache'
		$file = "./cache/".$ip;
		if(!file_exists($file)) {
		    // request
		    $json = file_get_contents($url);
		    $f = fopen($file,"w+");
		    fwrite($f,$json);
		    fclose($f);
		} else {
		    $json = file_get_contents($file);
		}

		$json = json_decode($json,true);
		return $json;
	}

	public function today()
	{
		$payload['geoip'] = $this->geoip();

		$payload['contactsSelector'] = $this->contacts();
		$payload['userdetails'] = $this->contacts[$this->userdata['name']];
		$payload['userdata'] = $this->userdata;
		
		if (!isset($this->userdata['name']))
			die("unable to read user data");
		
		$this->load->library('template');

		// template info
		$payload['menu'] = $this->menu;
		$payload['css'] = $this->css;
		$payload['js'] = $this->js;

		$payload['lid'] = "5";
		$payload['lunchaction'] = "update";

		$this->template->write_view('start', 'layouts/lunch_today', $payload);
		
		return $this->template->render();


	}
	
	public function contactsSelector($id)
	{
		
		$a = "<select  class='input-xlarge' id='".$id."' name='".$id."'>";
		$a .= "<option value=''></option>";
		foreach($this->contacts as $contact => $cdata)
		{
			if (!isset($cdata['email']))
				continue;
			
			$selected = "";
			if (isset($_SESSION['currentpo']['step'.$this->step][$id]))
				if ($_SESSION['currentpo']['step'.$this->step][$id] == $cdata['email'])
					$selected = "selected";
			
			$a .= "<option value='".$cdata['email']."' ".$selected.">".$contact." (".$cdata['email'].")</option>";
		}
		$a .= "<select>";
		
		return $a;
	}
	
	public function savepo()
	{
		var_dump($_POST);
		var_dump($_GET);
		var_dump($_SESSION);
		var_dump($_FILES);
		
	}
	
	public function newpo()
	{
		//$_SESSION['currentpo'] = NULL;
		
		$step = "1";
		if (isset($_GET['step']))
			$step = $_GET['step'];

		if (isset($_POST['step']))
			$step = $_POST['step'];
		
		$this->step = $step;
		
		if (isset($_POST) && count($_POST) > 0)
		{
			if (isset($_SESSION))
			{
				$_SESSION['currentpo']['step'.$step] = $_POST;
			}
		}
		
		
		if (isset($_POST['nextstep']))
			$step = $_POST['nextstep'];
		
		$payload['userdetails'] = $this->contacts[$this->userdata['name']];
		$payload['userdata'] = $this->userdata;
		
		if (!isset($this->userdata['name']))
			die("unable to read user data");
		
		$this->load->library('template');

		// template info
		$payload['menu'] = $this->menu;
		$payload['css'] = $this->css;
		$payload['js'] = $this->js;
		
		$payload['finalreadonly'] = false;
		
		if ($step == "1")
		{
			// step 1
			// date for pulldowns
			$payload['submitTo1'] = $this->contactsSelector("submitTo1");
			$payload['submitCc1'] = $this->contactsSelector("submitCc1");
			$payload['submitCc2'] = $this->contactsSelector("submitCc2");
			$payload['submitCc3'] = $this->contactsSelector("submitCc3");
			$payload['submitCc4'] = $this->contactsSelector("submitCc4");
			$payload['submitCc5'] = $this->contactsSelector("submitCc5");

		
		} else if ($step == "4") {
			$payload['sendToReviewer'] = $this->contactsSelector("sendToReviewer");
		
		} else if ($step == "5") {
			$payload['finalreadonly'] = true;
			$this->template->write_view('start', 'layouts/newpo_step5', $payload);
			$this->template->write_view('start', 'layouts/newpo_step1', $payload);
			$this->template->write_view('start', 'layouts/newpo_step2', $payload);
			$this->template->write_view('start', 'layouts/newpo_step3', $payload);
			$this->template->write_view('start', 'layouts/newpo_step4', $payload);
			$this->template->write_view('start', 'layouts/newpo_step5_2', $payload);
			
		}
		
		if ($step != "5")
		{
			$this->template->write_view('start', 'layouts/newpo_step'.$step, $payload);
		}
		
		return $this->template->render();
	}
}
