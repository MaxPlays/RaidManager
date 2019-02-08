/*$("#register-location").click(function(){
  $("#location").toggle("fold");
});
*/
var mymap = L.map('mapid').setView([49.4497, 11.0682], 12);

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWF4cGxheXMiLCJhIjoiY2pydW16M2NhMHg4bTQzcHExZXo1NmZ6cyJ9.pP7oLqWGYW-H8qE3uD71XA', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: ''
}).addTo(mymap);

$("#register-location").click(function(){
  setTimeout(function(){
    mymap.invalidateSize();
  }, 500);
});

var marker;

mymap.on("click", function(e){
    if(marker != null)
      marker.remove();
    marker = L.marker(e.latlng).addTo(mymap);
    $(".alert").alert();
});

$("#location-select").click(function(){
  if(marker != null){
    $("#location-result").html(marker.getLatLng().toString());
    marker.remove();
    mymap.setView([49.4497, 11.0682], 12);
  }
});
