<?php

if (isset($_POST['send'])) {
	//echo $_POST['hTown'];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link href="../public_html/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5uskKQALrQXONORGM2hPFxwCanhlvGAA&sensor=true">
    </script>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<!-- Create a map with Google Maps API-->
    <script>
      var geocoder;
	  var map;
	  function initialize() {
	    geocoder = new google.maps.Geocoder();
	    var latlng = new google.maps.LatLng(-34.397, 150.644);
	    var mapOptions = {
	      zoom: 8,
	      center: latlng,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }
	    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
	    codeAddress();
	  }
	  //We use the Geocode tool to get a mark with the hometown of the user, and then show it in the map
	  function codeAddress() {
	  	
	    var address = "<?php echo $_POST['hTown']; ?>";//<?php echo $_POST['hTown']; ?> ;
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	        map.setCenter(results[0].geometry.location);
	        var marker = new google.maps.Marker({
	            map: map,
	            position: results[0].geometry.location
	        });
	      } else {
	        alert("Geocode was not successful for the following reason: " + status);
	      }
	    });
	  }
    </script>

  </head>
  <body onload="initialize()">
  	<br/><a href="javascript:window.close();" target="_blank"><button class='btn btn-large btn-primary'>Close!</button></a><br/><br/>
    <div id="map-canvas"/>
  </body>
</html>

<?php
}
?>
