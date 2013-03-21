
$(function(){
	$('#datepicker').datepicker();
	
	$(".chzn-select").chosen(); 

    $('#myTab a:first').tab('show');


	initialize();

	$('.tooltips').tooltip();

	$('#lunchsave').button('loading');

	/*



	*/

/*
	$("#newlunchplan").modal({
		keyboard: false
	});
*/

});



var map = null;
var geocoder = null;
var gmarkers = [];
var gDirections;
	
function setDirections(address) {
	var fromAddress = prompt("Enter a starting address.");
	gDirections.load("from:" + fromAddress + " to: " + address);
	$('#directions').show('slow');
}

function markerClick(x) {
	GEvent.trigger(gmarkers[x], "click");
}
	
function showAddress(address, info_text, i) {
      if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
//              alert(address + " not found");
            } else {
			  marker= new GMarker(point);
			  gmarkers[i] = marker;
              map.addOverlay(gmarkers[i]); 
			  GEvent.addListener(gmarkers[i], "click", function() {
           	  gmarkers[i].openInfoWindow(info_text);
			 });
          	}
          }
        );
      }
   }	
	
function centerAddress(address) {
	geocoder.getLatLng(
		address,
		function(point) {
			map.setCenter(point, 11);
        });
}

function selectRestaurant(id, name, address, phone, url)
{
	
	$('#chosenrestaurant').val(name);
	$('#chosenrestaurant_a_g').show();
	$('#chosenrestaurant_p_g').show();
	$('#chosenrestaurant_a').val(address);
	$('#chosenrestaurant_p').val(phone);
	$('#chosenrestaurant_id').val(id);
	$('#chosenrestaurant_url').val(url);

	$('#lunchsave').removeAttr("disabled");
	$('#lunchsave').removeClass("disabled");

}

function savelunchtoday()
{
	var selectArray = $('select').val();
    var invitees = [];
    for (var i = 0; i < selectArray.length; i++) {
        invitees.push(selectArray[i].toLowerCase());
    }

    var date = $('#datepicker').val();
	var time = $('#timepick1').val();
	var near = $('#address').val();
	var transportation = $('#transportation').val();
	var placeName = $('#chosenrestaurant').val();
	var placeAddress = $('#chosenrestaurant_a').val();
	var placePhone = $('#chosenrestaurant_p').val();
	var placeYID = $('#chosenrestaurant_id').val();
	var chosenrestaurant_url = $('#chosenrestaurant_url').val();
	var lunchaction = $('#lunchaction').val();
	var notes = $('#notes').val();

	var lid = "-1";
	if ($('#lid').val() != "")
	{
		lid = $('#lid').val();
	}

	$('#topmessagebar').html("Saving lunch details");
	$('#topmessagebar').fadeIn('fast');

	$.post("/lunch/save", 
		{ 
			invitees: invitees, 
			date: date, 
			time: time, 
			near: near, 
			transportation: transportation, 
			placeName: placeName, 
			placeAddress: placeAddress, 
			placePhone: placePhone, 
			placeYID: placeYID, 
			lunchaction: lunchaction,
			lid: lid,
			notes: notes,
			url: chosenrestaurant_url
		},
		function(data) {
			$('#lid').val(data.lid);
			$('#lunchaction').val("update");

			$('#topmessagebar').fadeOut('fast');
			
			$('#topmessagebar').html("Lunch details saved & invitations sent!");
			$('#topmessagebar').fadeIn('fast');
			$('#topmessagebar').delay('5000').fadeOut('slow');
				
		}
	);


}

function retrieveYelp(){
	var term = $("#term").val();
	var location = $("#address").val();

	$('#yelpsearchworking').fadeIn();

		navigator.geolocation.getCurrentPosition(GetLocation);
		function GetLocation(location) {
		    defLat = location.coords.latitude;
		    defLong = location.coords.longitude;
		}


	$.getJSON("/lunch/yelp?term="+encodeURI(term)+"&location="+encodeURI(location) ,
        function(data) {
	  		$('#yelpsearchtextpre').hide();
	  		$('#yelpsearchworking').hide();
			handleData(data);
        }
    );
}
	
function handleData(data){
	var markerLink = [];
	var directionsLink = [];
	var divMarker = document.createElement('div');
	var divContent = document.createElement('div');
	var divAddress = document.createElement('div');
	var enterAddress =$("#address").val();
	
//	map.clearOverlays();
//	centerAddress(enterAddress);
	
	if (data.message.text == "OK") {
		if(data.businesses.length == 0) {
		//alert("Error: No businesses were found near this location");
		return;
		}

	for(var i= 0; i<data.businesses.length; i++) {
	
//		markerLink.push('javascript:markerClick('+i+')');
//		markerLink[i] = markerLink[i].replace(/[']/g,"");
//		directionsLink.push(data.businesses[i].address1 + " " + data.businesses[i].city + " " + data.businesses[i].state + " " + data.businesses[i].zip);
	
	/*
	var R = 6378.16; // km
	var PIx = 3.141592653589793;
	
	var dLat = (defLat-data.businesses[i].latitude) * PIx / 180;
	var dLon = (defLong-data.businesses[i].longitude) * PIx / 180;

	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
	        Math.cos(data.businesses[i].latitude * PIx / 180) * 
	        Math.cos(defLat * PIx / 180) * 
	        Math.sin(dLon/2) * Math.sin(dLon/2); 
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
	var d = R * c;
*/
	var results = [
	{
		marker: markerLink[i],
		directions: directionsLink[i],	
		photoURL: data.businesses[i].photo_url.replace(/^http:\/\//i, 'https://'),
		mobile_url: data.businesses[i].mobile_url.replace(/^http:\/\//i, 'https://'),
		imgRating: data.businesses[i].rating_img_url.replace(/^http:\/\//i, 'https://'),
		name: data.businesses[i].name, 
		address: data.businesses[i].address1,
		city: data.businesses[i].city,
		state: data.businesses[i].state,
		zip: data.businesses[i].zip, 
		review_count: data.businesses[i].review_count,
		distance: Math.round(data.businesses[i].distance*10)/10,
		id: data.businesses[i].id,
		latitude: data.businesses[i].latitude,
		longitude: data.businesses[i].longitude,
		phone:data.businesses[i].phone,
		url: data.businesses[i].url
	}]; 
	
	if ( $('#div-results > *').length > 0 ) {
    	$('#div-results').children().remove();
	}
	
	$("#businessInfo").tmpl(results).appendTo(divContent);
	$("#markerInfo").tmpl(results).appendTo(divMarker);
	$("#yelpAddress").tmpl(results).appendTo(divAddress);
	var yelp_info= divMarker.innerHTML;
	var yelp_address = divAddress.innerHTML;
	
	
	while (divMarker.hasChildNodes() || divAddress.hasChildNodes()) {
		divMarker.removeChild(divMarker.firstChild);
		divAddress.removeChild(divAddress.firstChild);
	}
	showAddress(yelp_address, yelp_info, i);
		}
	}	
	else {
	//	alert("Error: " + data.message.text);
	}
	$("#div-results").append(divContent);
	
	$('.tooltips').tooltip();

}
