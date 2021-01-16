<input id="pac-input" class="controls form-control" type="text" placeholder="@lang('admin.Enter a location')">
<br>
<div class="row">
<div class="form-group col-md-6"><input type="text" name="lat" id="lat" class="form-control" placeholder="Latitud" value="{{ $data->lat }}"></div>
<div class="form-group col-md-6"><input type="text" name="lng" id="lng" class="form-control" placeholder="Longitud" value="{{ $data->lng }}"></div>
</div>

    <div id="map"></div>
    <div id="infowindow-content">
      <span id="place-name"  class="title"></span>
      <span id="place-id"></span><br>
      <span id="place-address"></span>
    </div>

    <script>
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

function initMap() {
  var map = new google.maps.Map(
      document.getElementById('map'),
      {center: {lat: 31.326015, lng: 75.576180}, zoom: 13});

  var input = document.getElementById('pac-input');

  var autocomplete = new google.maps.places.Autocomplete(input);

  autocomplete.bindTo('bounds', map);

  // Specify just the place data fields that you need.
  autocomplete.setFields(['place_id', 'geometry', 'name', 'formatted_address']);

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById('infowindow-content');
  infowindow.setContent(infowindowContent);

  var geocoder = new google.maps.Geocoder;

  var marker = new google.maps.Marker({map: map});
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });

  autocomplete.addListener('place_changed', function() {
    infowindow.close();
    var place = autocomplete.getPlace();

    if (!place.place_id) {
      return;
    }
    geocoder.geocode({'placeId': place.place_id}, function(results, status) {
      if (status !== 'OK') {
        window.alert('Geocoder failed due to: ' + status);
        return;
      }

      map.setZoom(11);
      map.setCenter(results[0].geometry.location);


      // Set the position of the marker using the place ID and location.
      marker.setPlace(
          {placeId: place.place_id, location: results[0].geometry.location});

      marker.setVisible(true);

      infowindowContent.children['place-name'].textContent = place.name;
      infowindowContent.children['place-id'].textContent = place.place_id;
      infowindowContent.children['place-address'].textContent = results[0].formatted_address;

      document.getElementById('lat').value = results[0].geometry.location.lat();
      document.getElementById('lng').value = results[0].geometry.location.lng();
      infowindow.open(map, marker);
    });
  });
}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $google_key }}&libraries=places&callback=initMap"
        async defer></script>
