$(".button-participate").on("click", function(e){
  $("#raid-id").html($(this).parent().siblings("td").first().html());
});

$("#participate").click(function(){
  $.post("participate.php", {id: $("#raid-id").html(), number: $("#participate-number").val()}).done(function(data){
    $("#alert-2-wrapper").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> ' + data + '.</div>');
  });
});
