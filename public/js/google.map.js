var initialLocation;
var browserSupportFlag =  new Boolean();
var map;
var geocoder;
var markersArray = [];

function init()
{
	var latlng = new google.maps.LatLng(-34.397, 150.644);
	var myOptions = {
	  zoom: 16,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	geocoder = new google.maps.Geocoder();
	
	google.maps.event.addListener(map, 'click', function( event ) {
		drawMarker( event.latLng , 1);
	})
}

function detectUserLocation()
{
	// Try W3C Geolocation (Preferred)
	if(navigator.geolocation) {
		browserSupportFlag = true;
		navigator.geolocation.getCurrentPosition(function(position) {
		  initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
		  map.setCenter(initialLocation);
		  
		  drawMarker( initialLocation );
	      
		}, function() {
		  	//handleNoGeolocation(browserSupportFlag);
		});
	// Try Google Gears Geolocation
	} else if (google.gears) {
		browserSupportFlag = true;
		var geo = google.gears.factory.create('beta.geolocation');
		geo.getCurrentPosition(function(position) {
		  initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
		  map.setCenter(initialLocation);
		}, function() {
		  //handleNoGeoLocation(browserSupportFlag);
		});
	// Browser doesn't support Geolocation
	} else {
		//browserSupportFlag = false;
		//handleNoGeolocation(browserSupportFlag);
	}	
}

function drawMarker( _location , _fill ){
	deleteAllMarkers();
	marker = new google.maps.Marker({
	          map: map,
	          draggable:true,
	          position: _location
	      });
	markersArray.push(marker);
	if(_fill){
		geocoder.geocode( {'location':_location}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
		    $('#address').val( results[0].formatted_address );
		    $('#lat').val( results[0].geometry.location );
		  } else {
		    //ups something is wrong do nothing
		  }
		});	
	}
}

function deleteAllMarkers(){
	if (markersArray) {
		for (i in markersArray) {
		  	markersArray[i].setMap(null);
		}
		markersArray.length = 0;
	}
}

function drawAddressInfo( _address )
{
	geocoder.geocode( { 'address': _address}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
		    map.setCenter(results[0].geometry.location);
		    drawMarker( results[0].geometry.location, 1 );
		  } else {
		    //ups something is wrong do nothing
		  }
	});
}

$(document).ready(function(){
	init();
	
	location_name = $('#location_id option:selected').text().trim();
	location_id = $('#location_id').val();
	if(location_name && location_id != 0){
		drawAddressInfo( location_name );
	} else {
		detectUserLocation();
	}

	$('#location_find').click(function(){
		location_address = $("#address").val().trim();
		if(location_address){
			drawAddressInfo(location_address);
		}
		return false;
	});
	
	$('#location_ok').click(function(){
		selected_address = $('#address').val().trim();
		selected_address_lat = $('#lat').val().trim();
		if(selected_address && selected_address_lat){
			$('#ad_address').val(selected_address);
			$('#ad_lat_lng').val(selected_address_lat);
		}
		$.fancybox.close();
	});
	
	
});