<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta name="description" content="The lunch planning site" />
	<meta name="keywords" content="lunch planning" />
	<meta name="author" content="Andrei Oprisan" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?= $title ?></title>
	<?php foreach($css as $link): ?>
	<link type="text/css" rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/assets/css/<?= $link ?>.css" />
	<?php endforeach; ?>
	<?php foreach($js as $link): ?>
	<script type="text/javascript" src="http://<?= $_SERVER['HTTP_HOST'] ?>/assets/js/<?= $link ?>.js"></script>
	<?php endforeach; ?>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.js" type="text/javascript"></script>
<!--	<script src="https://maps.google.com/maps?file=api&v=2&key=AIzaSyCI5vFysWfhRX5fR52_EawuhpSTqvmp6BM" type="text/javascript"></script>
-->
	<script type='text/javascript'>var TBRUM=TBRUM||{};TBRUM.q=TBRUM.q||[];TBRUM.q.push(['mark','firstbyte',(new Date).getTime()]);(function(){var a=document.createElement('script');a.type='text/javascript';a.async=true;a.src=document.location.protocol+'//insight.torbit.com/v1/insight.min.js';var b=document.getElementsByTagName('script')[0];b.parentNode.insertBefore(a,b)})();</script>
	<script type="text/javascript">
	var defLat = <?php echo $geoip['cityLatitude'] ?>;
	var defLong = <?php echo $geoip['cityLongitude'] ?>;
	var defPrec = "15";

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-29444973-1']);
	  _gaq.push(['_setDomainName', 'justgetlunch.com']);
	  _gaq.push(['_setAllowLinker', true]);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	  var locdata = 'http://api.easyjquery.com/ips/?ip=50.133.180.144&full=true';

	  function initialize() {
//		$('#map-container').hide();
//		$('#directions').hide();
		
		$('#yelpAction').click(function() {
	//		$('#form-container').hide('slow',function(){
//				$('#map-container').show('slow');
//				map.checkResize();
	//		});
	 	});
	 	
	 	$('#search-link').click(function(){
//		 	$('#directions').hide('slow', function(){
//		 		$('#map-container').hide('slow', function(){
	//	 			$('#form-container').show('slow');
//		 		});
//	 		});
	 	});
		

		navigator.geolocation.getCurrentPosition(GetLocation);
		function GetLocation(location) {
		    defLat = location.coords.latitude;
		    defLong = location.coords.longitude;
		}

/*

		if (GBrowserIsCompatible()) {
		    map = new GMap2(document.getElementById("map-canvas"));
			map.addControl(new GLargeMapControl());
			gDirections = new GDirections(map, document.getElementById("directions"));
		    map.setCenter(new GLatLng(<?php echo $geoip['cityLatitude'] ?>, <?php echo $geoip['cityLongitude'] ?>), 10);
		    map.setCenter(new GLatLng(defLat, defLong), defPrec);
		    geocoder = new GClientGeocoder();
		    }
*/
		}


	</script>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
	    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="brand" href="/" style="position: absolute; left: 3%; "><font color="red">just get lunch</font><small style="font-size: 17px; margin-left: 0px;font-weight: 100px;color: black 	;"> the lunch social network </small></a>
		<div class="nav-collapse">
		<?php if (isset($menu) && count($menu) > 0) { ?>
		
		<ul class="nav" style="position:absolute; left: -30%;">
			<?php 
			foreach ($menu as $menuitem_val) {
			
			if (isset($menuitem_val['username']))
				continue;

			if (isset($menuitem_val['calorietracker']))
				continue;

			if ($menuitem_val['align'] == "right")
				continue;
					
			if (isset($menuitem_val['name']) && isset($menuitem_val['val'])) {
				if (is_array($menuitem_val['val']))
				{ ?>
				<li class="dropdown" style="padding-right: 30px;">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $menuitem_val['name'] ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php 
						foreach ($menuitem_val['val'] as $menuitem_dropdown) { ?>
							<?php if (!isset($menuitem_dropdown['val']) && !isset($menuitem_dropdown['name'])) {?>
								<li class="divider"></li>
							<?php } else { 
								?>
								<li style="color: black;"><a href="<?= $menuitem_dropdown['val']?>"><?= $menuitem_dropdown['name']?></a></li>
							<?php } ?>
						<?php } ?>
					</ul>
				</li>
				<?php } else { ?>
						<li><a href="<?= $menuitem_val['val'] ?>"><?= $menuitem_val['name'] ?></a></li>
				<?php }
				}
			} ?>
		</ul>
		<?php 
		} ?>
		<ul class="nav pull-right">
			<?php 
			if ((isset($menuitem_val) && count($menuitem_val) > 0)) 
			{
				foreach ($menu as $menuitem_val) 
				{ 
				?>
				<?php if (isset($menuitem_val['align']) && $menuitem_val['align'] == "right") { ?>
					<?php if (isset($menuitem_val['username'])) { ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">me <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Your Profile</a></li>
							<li class="divider"></li>
							<li><a href="#">Account Settings</a></li>
							<li><a href="/facebook_auth/logout">Log Out</a></li>
						</ul>
					</li>
					<?php } else { ?>
					<?php 
					if (isset($menuitem_val['login'])) { ?>
						<li><a href="<?= $menuitem_val['val'] ?>"><?= $menuitem_val['name'] ?></a></li>
					<?php } else { ?>
						<?php if (is_array($menuitem_val['val']))
						{ ?>
						<li class="dropdown" style="padding-right: 5px;">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $menuitem_val['name'] ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<?php 
								foreach ($menuitem_val['val'] as $menuitem_dropdown) { ?>
									<?php if (!isset($menuitem_dropdown['val']) && !isset($menuitem_dropdown['name'])) {?>
										<li class="divider"></li>
									<?php } else { 
										?>
										<li><a href="<?= $menuitem_dropdown['val']?>"  style="color: black;"><?= $menuitem_dropdown['name']?></a></li>
									<?php } ?>
								<?php } ?>
							</ul>
						</li>
						<?php } else { ?>
								<li><a href="<?= $menuitem_val['val'] ?>" ><?= $menuitem_val['name'] ?></a></li>
						<?php } ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } 
			} ?>
		</ul>
		</div>

    </div>
  </div>
</div>
<br>
<br>

<div class="container">
	<?= $homepage ?>
	<div class="content" style="min-height: 530px;">
		<?= $alertitemadd ?>
		<?= $content ?>

		<?= $start ?>

		<?= $dashboard ?>

		<?= $nikeplussync ?>
		<?= $nikeplusruns ?>
		
		<?= $nutritionsearch ?>
		
		<?= $login ?>

		<?= $nutrition ?>
		<?= $nutritionlog ?>
		<?= $nutritionfavorites ?>
		<?= $workout ?>
		<?= $workoutlog ?>
		<?= $workoutfavorites ?>

		<?= $privacy ?>
		<?= $tos ?>


	</div>



	
</div> 
<footer>
      <div class="footer-content">
        <ul>
          <li class="">
            <a href="#">&copy; justgetlunch llc, 2012</a>
          </li>
        </ul>
		<div class="footer-pages">
			<a class="branding" href="/support">support</a>
			<a class="branding" href="/privacy">privacy</a>
			<a class="branding" href="/tos">terms</a>
		</div>
      </div>
    </footer>

</body>
</html>