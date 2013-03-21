<?php

class Gitsync extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
	}
	
	function index()
	{
		$output = shell_exec('sudo ./gitsync.sh');
		echo "<pre>$output</pre>";
	}
}
