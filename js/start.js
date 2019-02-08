$("#register-start").click(function(){
  var arena = $("#register-arena").val();
  var pokemon = $("#register-pokemon").val();
  var time = $("#register-time").val();
  var latlng = $("#location-result").html().trim().replace("LatLng(", "").replace(")", "").split(",");
  var lat = latlng[0];
  var lng = latlng[1];

  if(arena.length > 0 && pokemon.length > 0 && time.length > 0 && $("#location-result").html().length > 0){
    $("#registerModal").modal("toggle");
    clear();
    jQuery.post("start.php", {arena: arena, pokemon: pokemon, time: time, lat: lat, lng: lng}).done(function(data){
      $("#alert-2-wrapper").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> ' + data + '.</div>');
    });
  }else{
    $("#alert-wrapper").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong> You have to fill out all fields.</div>');
  }
});

$("#register-cancel").click(function(){
  clear();
});

function clear(){
  $("#register-arena").val("");
  $("#register-pokemon").val("");
  $("#register-time").val("");
  $("#location-result").html("");
}
