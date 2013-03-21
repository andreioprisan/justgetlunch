<br>
<div class="page-header">
<br>
<h1>Let's eat! <small>make lunch plans for today</small></h1>
</div>
<div class="row">
<div class="span6">

	<form class="form-horizontal" action="/lunch/today" method="post">
		<input type="hidden" id="author_id" name="author_id" value="<?= $userdata['id']; ?>" />
		<input type="hidden" id="author_email" name="author_email" value="<?= $userdata['email']; ?>" />

	    <fieldset>
	      <div class="control-group">
	        <label class="control-label" for="focusedInput">Invite</label>
	        <div class="controls">
	        	<select data-placeholder="Invite your coworkers" style="width:350px;" class="chzn-select" multiple tabindex="6">
				  <option value=""></option>
				  <optgroup label="Google Apps Coworkers">
				  	<?= $contactsSelector ?>
				  </optgroup>
				</select>
	        </div>
	      </div>
	      
	      <div class="control-group">
	        <label class="control-label" for="inputError">When</label>
	        <div class="controls">
		    	<input type="text" class="span2" value="<?= date('m/d/y'); ?>" data-date-format="mm/dd/yy" id="datepicker" style="width: 60px"> at 
		    	<script>
				  $(function() {
					$('#timepick1').timepicker({ 'scrollDefaultNow': true })
				  });
				</script>
		    	<input id="timepick1" type="text" class="time"  style="width: 60px"/>

		    	<!--
		    	<select data-placeholder="what time?" style="width:120px;" class="chzn-select" multiple tabindex="6">
				  <option value=""></option>
				  <optgroup label="AM">
					  <option value="8:00 AM">8:00 AM</option>
					  <option value="8:15 AM">8:15 AM</option>
					  <option value="8:30 AM">8:30 AM</option>
					  <option value="8:45 AM">8:45 AM</option>
					  <option value="9:00 AM">9:00 AM</option>
					  <option value="9:15 AM">9:15 AM</option>
					  <option value="9:30 AM">9:30 AM</option>
					  <option value="9:45 AM">9:45 AM</option>
					  <option value="10:00 AM">10:00 AM</option>
					  <option value="10:15 AM">10:15 AM</option>
					  <option value="10:30 AM">10:30 AM</option>
					  <option value="10:45 AM">10:45 AM</option>
					  <option value="11:00 AM">11:00 AM</option>
					  <option value="11:15 AM">11:15 AM</option>
					  <option value="11:30 AM">11:30 AM</option>
					  <option value="11:45 AM">11:45 AM</option>
				  </optgroup>
					  <optgroup label="PM">
					  <option value="12:00 PM">12:00 PM</option>
					  <option value="12:15 PM">12:15 PM</option>
					  <option value="12:30 PM">12:30 PM</option>
					  <option value="12:45 PM">12:45 PM</option>
					  <option value="1:00 PM">1:00 PM</option>
					  <option value="1:15 PM">1:15 PM</option>
					  <option value="1:30 PM">1:30 PM</option>
					  <option value="1:45 PM">1:45 PM</option>
					  <option value="2:00 PM">2:00 PM</option>
					  <option value="2:15 PM">2:15 PM</option>
					  <option value="2:30 PM">2:30 PM</option>
					  <option value="2:45 PM">2:45 PM</option>
					  <option value="3:00 PM">3:00 PM</option>
					  <option value="3:15 PM">3:15 PM</option>
					  <option value="3:30 PM">3:30 PM</option>
					  <option value="3:45 PM">3:45 PM</option>
					  <option value="4:00 PM">4:00 PM</option>
					  <option value="4:15 PM">4:15 PM</option>
					  <option value="4:30 PM">4:30 PM</option>
					  <option value="4:45 PM">4:45 PM</option>
					  <option value="5:00 PM">5:00 PM</option>
				  </optgroup>
				</select>
				-->
	        </div>
	      </div>
	      <div class="control-group">
	        <label class="control-label" for="inputWarning">Near</label>
	        <div class="controls"><?php //var_Dump($geoip); ?>
	          <input type="text" id="address" style="width:340px;"  name="address" value="<?php echo $geoip['cityName'] ?>, <?php echo $geoip['regionName'] ?>">
	        </div>
	      </div>

	      <div class="control-group">
	        <label class="control-label" for="inputSuccess">Transportation</label>
	        <div class="controls">
	          <input type="text" id="transportation" name="transportation" placeholder="How many people can you drive?" style="width:340px;" >
	        </div>
	      </div>

	      <div class="control-group">
	        <label class="control-label" for="inputSuccess">Restaurant</label>
	        <div class="controls">
	          <input type="text" id="chosenrestaurant" name="chosenrestaurant" value="Search below & select a restaurant from the right" style="width:340px;" disabled >
	        </div>
	      </div>

		  <div class="control-group" style="display:none" id="chosenrestaurant_a_g">
	        <label class="control-label" for="inputSuccess">Where</label>
	        <div class="controls">
	          <input type="text" id="chosenrestaurant_a" name="chosenrestaurant_a" value="Search above & select a restaurant from the right" style="width:340px;" disabled >
	        </div>
	      </div>

		  <div class="control-group" style="display:none" id="chosenrestaurant_p_g">
	        <label class="control-label" for="inputSuccess">Phone</label>
	        <div class="controls">
	          <input type="text" id="chosenrestaurant_p" name="chosenrestaurant_p" value="Search above & select a restaurant from the right" style="width:340px;" disabled >
	          <input type="hidden" id="chosenrestaurant_id" name="chosenrestaurant_id" value="">
	          <input type="hidden" id="chosenrestaurant_url" name="chosenrestaurant_url" value="">
	          <input type="hidden" id="lunchaction" name="lunchaction" value="<?= $lunchaction ?>">
	          <input type="hidden" id="lid" name="lid" value="<?= $lid ?>">
	        </div>
	      </div>

	      <div class="control-group" style="" id="notes_g">
	        <label class="control-label" for="inputSuccess">Notes</label>
	        <div class="controls">
	          <input type="text" id="notes" name="notes" value="" style="width:340px;">
	        </div>
	      </div>


	      <div class="control-group">
	        <label class="control-label" for="inputSuccess"></label>
	        <div class="controls">
	        	<div id="topmessagebar" class="alert alert-info" style="width:300px; display:none">aa</div>

				<a id="lunchsave" href="#" id="save" class="btn btn-success" onclick="savelunchtoday();" data-loading-text="Save & Invite">Save & Invite</a>
	        </div>
	      </div>

	    </fieldset>
	  </form>

</div>
<div class="span6">
          <input type="text" id="term" name="term" placeholder="Search for a restaurant by cuisine or name" style="width:368px;" >
          <input type="button" id="yelpAction" onclick="retrieveYelp();" value="Yelp Search" class="btn btn-primary" style="margin-bottom: 9px;">

<div id="yelpsearchbox"class="hero-unit" style="width: 100%">
	<div id="yelpsearchtextpre">
		<p>You can search for a restaurant by cuisine or name above...</p><br>
	</div>
	<div id="yelpsearchworking" style="display:none" class="alert alert-block alert-danger">Please wait while we look for your food picks.. back in a jiffy</div>

	<div id="div-results"></div>
</div>
<img src="https://media1.ak.yelpcdn.com/static/201206261914090300/img/developers/Powered_By_Yelp_White.png">

    <script id="businessInfo" type="text/x-jquery-tmpl">
			<div class="place-info alert alert-block alert-info">
				<!--<p><img src='${photoURL}' /></p>-->
				<p>
				<a href="#" onclick="selectRestaurant('${id}','${name}', '${address}, ${city}, ${state} ${zip}', '${phone}', '${url}');" class="btn btn-mini btn-success"  style="text-decoration: none">Pick it!</a>
				<img src='${imgRating}' /> <font style="font-size: 16px"><b>${name}</b></font> 
				<a href="#" rel="tooltip" class="tooltips" data-original-title="Address: ${address}, ${city}, ${state} ${zip} Phone: ${phone}" style="text-decoration: none"><span class="label label-info" style="color: white;">@${distance}mi</span></a> 
<!--				<a href="#" rel="tooltip" class="tooltips" data-original-title="${address}, ${city}, ${state} ${zip}" style="text-decoration: none"><span class="label label-info" style="color: white;">Address</span></a> -->
<!--				<a href="#" rel="tooltip" class="tooltips" data-original-title="${phone}" style="text-decoration: none"><span class="label label-info" style="color: white;">Phone</span></a>				  -->
				<a href="${mobile_url}" class="btn btn-mini"  style="text-decoration: none" target="_blank">${review_count} Reviews</a>
				<a href="http://maps.google.com?q=${address} ${city} ${state} ${zip}" class="btn btn-mini"  style="text-decoration: none" target="_blank">Map It</a>
			</div>
			<br>
	</script>
	<script id="markerInfo" type="text/x-jquery-tmpl">
			<div class="place-info" style="align:left">
				<p><font style="font-size: 18px"><b>${name}</b></font> <br> 
				<span class="label label-info">Rating</span> <img src='${imgRating}' /><br> 
				<span class="label label-info">Address</span> ${address} ${city} ${state} ${zip}<br> 
				<span class="label label-info">Phone</span> ${phone} <br>
			</div>
		</script>
	<script id="yelpAddress" type="text/x-jquery-tmpl">
			${address} ${city}, ${state} ${zip}
	</script>


</div>
</div>
