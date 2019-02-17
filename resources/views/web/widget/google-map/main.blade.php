<div id="map" style="width: {{$config->width}}; height: {{$config->height}}; background: {{$config->backgroundColor}}"></div>
<script>
	function initMap() {
		var VN = {lat: {{$config->lat}}, lng: {{$config->long}}};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: {{$config->zoom}},
            center: VN
		});

        var infowindow = new google.maps.InfoWindow({
            content: '{!!preg_replace( "/\r|\n/", "", $widget->content)!!}'
		});
        
		var marker = new google.maps.Marker({
			position: VN,
			map: map
		});

		marker.addListener('click', function() {
			infowindow.open(map, marker);
		});
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{$config->apiKey}}&callback=initMap"></script>