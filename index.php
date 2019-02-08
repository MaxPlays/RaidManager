<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Raid Manager</title>

    <meta charset="utf-8">
    <meta name="author" content="Maximilian Negedly">
    <meta name="description" content="A raid manager for Nuremberg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>

   <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
    integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
    crossorigin=""></script>
  </head>
  <body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Nuremberg Raid Manager</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Overview <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">Start raid</a>
          </li>
        </ul>
      </div>
    </nav>

    <div id="alert-2-wrapper"></div>
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Start raid</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="alert-wrapper"></div>
        <form>
          <div class="form-group">
            <label for="register-arena">Arena</label>
            <input type="text" class="form-control" id="register-arena" placeholder="Arena name">
            <div class="btn btn-outline-dark mt-2" id="register-location" data-toggle="modal" data-target="#test">Location</div>
            <small class="form-text" id="location-result"></small>
          </div>
          <div class="form-group">
            <label for="register-pokemon">Pokémon</label>
            <input type="text" class="form-control" id="register-pokemon" aria-describedby="emailHelp" placeholder="Pokémon name">
          </div>
          <div class="form-group">
            <label for="register-time">Meeting time</label>
            <input type="time" class="form-control" id="register-time" placeholder="Meeting time">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="register-cancel">Cancel</button>
        <button type="button" class="btn btn-primary" id="register-start">Start</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="test" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="testLabel">Select location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="location">
          <div id="mapid" style="width: 100%; height: 300px;"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="location-select">Select</button>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid mt-4">
  <div class="card">
    <div class="card-header bg-dark text-light">
      <h5>Active raids in Nuremberg</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Arena</th>
              <th scope="col">Pokémon</th>
              <th scope="col">Meeting time</th>
              <th scope="col">Participants</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!--
            <tr>
              <td>1</td>
              <td>Test</td>
              <td>Test1</td>
              <td>Test3</td>
              <td>12</td>
              <td>
                <button class="btn btn-outline-dark button-participate" data-toggle="modal" data-target="#participateModal">Participate</button>
              </td>
            </tr>
            -->
            <?php
              include("sql.php");

              $result = $conn->query("SELECT * FROM raids ORDER BY time ASC;");
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  if($row["time"] < date_timestamp_get(date_create())){
                    $conn->query("DELETE FROM raids WHERE id=".$row["id"].";");
                  }else{
                    //https://www.google.at/maps/place/49.454394+11.070501
                    echo('<tr>
                      <td>'.$row["id"].'</td>
                      <td><a href="https://www.google.at/maps/place/'.$row["lat"].'+'.$row["lng"].'" target="blank">'.$row["arena"].'</a></td>
                      <td>'.$row["pokemon"].'</td>
                      <td>'.$row["timeformatted"].'</td>
                      <td>'.$row["participants"].'</td>
                      <td>
                        <button class="btn btn-outline-dark button-participate" data-toggle="modal" data-target="#participateModal">Participate</button>
                      </td>
                    </tr>');
                  }
                }
              }

              $conn->close();
             ?>
          </tbody>
        </table>
      </div>
    </div>
</div>
</div>

<div class="modal fade" id="participateModal" tabindex="-1" role="dialog" aria-labelledby="participateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="participateModalLabel">Participate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="participate-number">Number of participants</label>
            <input type="number" min="1" class="form-control" required id="participate-number" value="1" placeholder="Number of participants">
            <span style="display: none;" id="raid-id"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="participate">Participate</button>
      </div>
    </div>
  </div>
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <script src="js/location.js" charset="utf-8"></script>
  <script src="js/start.js" charset="utf-8"></script>
  <script src="js/participate.js" charset="utf-8"></script>
  </body>
</html>
