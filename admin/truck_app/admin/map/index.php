<!DOCTYPE html>
<html lang="en">
<head>
    <title>22Ggroup</title>
    <link rel="icon" sizes="72x72" href="../public/images/favicon-96x96.png">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <style>
        #map {
            height: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .title {
            font-weight: bold;
        }
        .navigate {
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #D4AF37;
            font-family: Roboto;
            position:fixed;
            z-index:1;
            border:solid;
            border-width:0 0 10px 0;
            border-color:#fff;
            width:100%;
        }
        #navigate-container {
            padding-bottom: 12px;
            padding: 10px 10px 10px 10px;
        }
        label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }
        #pac-input {
            background-color: #D4AF37;
            font-family: Roboto;
            font-size: 20px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width:40%;
        }
        #pac-input:focus {
            border-color: #4d90fe;
            width:40%;
        }
        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }
        #header {
            color: #000000;
            font-size: 20px;
            padding: 6px 12px;
            border:solid;
            border-width:0 0 0 2px;
            border-color:#696969;
        }
        #logout {
            color: #000000;
            font-size: 20px;
            padding: 6px 12px;
            border:solid;
            border-width:0 2px 0 2px;
            border-color:#696969;
        }

    </style>
  </head>
  <body>
    <?php
    session_start();
    $servername = "localhost";
    $username = "nadaa93i_gaurav";
    $password = "root@123";
    $dbname = "nadaa93i_Jrarron";
    try 
    {   $message="";
        $conn = new mysqli($servername, $username, $password,$dbname);
        $end=$_SESSION["end"];
        if($end!="true"){
            echo '<script>
                    window.location="../../admin/";
                </script>';
        }
        if(isset($_POST["done"])){
            $manager_no=$_POST["manager"];

        }
    }
    catch(PDOException $e)
    {
        $message="Error in Network";
        $_SESSION["end"]="false";
    }
    ?>
    <div class="navigate" id="navigate">
        <div id="navigate-container">
            <a id="header" style="text-decoration:none" href="../add_manager">Add Manager</a>
            <a id="header" style="text-decoration:none" href="../add_driver">Add Driver</a>
            <a id="header" style="text-decoration:none" href="../delete_manager">Edit Manager's Detail</a>
            <a id="header" style="text-decoration:none" href="../delete_driver">Edit Driver's Detail</a>
            <a id="logout" style="text-decoration:none" href="../../admin/">Logout</a>
            <select id="pac-input" name="manager" required="required"  class="manager" size="1">
                <?php
                    session_start();
                    $end=$_SESSION["end"];
                    if($end!="true"){
                        echo '<script>
                            window.location="../../admin/";
                        </script>';
                    }
				    $servername = "localhost";
                    $username = "nadaa93i_gaurav";
                    $password = "root@123";
                    $dbname = "nadaa93i_truck_app";
                    $con = new mysqli($servername, $username, $password,$dbname);
                    try {
                        $sql="SELECT * FROM `manager` ORDER BY id";
                        $result = mysqli_query($con,$sql) or die(mysql_error());
                        if(mysqli_num_rows($result) > 0)
                        {   echo '<option value="select">--Select an Manager--</option>';
                            while($row=mysqli_fetch_row($result)){
                                echo '<option value="'.$row[1].'">'.$row[0].'</option>';
                            }
                        }
                        else
                        {
                                echo '<option value="null">No managers yet</option>';
                        }
                    }
                    catch(PDOException $e)
                    {
                                echo '<option value="null">OOP;s an error occured!! Try again later</option>';
                                $_SESSION["end"]="false";
                    }
                    ?>
            </select>
        </div>
    </div>
    <div id="map"></div>
    <script type="text/javascript">
    var markerss = [];
    var customLabel = {
        driver: {
          label: 'D'
        },
        manager: {
          label: 'M'
        }
    };
    $(document).ready(function(){
        setInterval(function() {
            DeleteMarkers();
            initMap();
        }, 20000);
        $("select.manager").change(function(){
            initMap();
    });
    }); 

    function initMap() {
        var selectedCountry = $("select.manager").children("option:selected").val();
        if(selectedCountry=="select")
        {
            DeleteMarkers();
            var indore = {lat: 22.7196, lng: 75.8577};
            var map = new google.maps.Map(document.getElementById('map'), {center: indore,zoom: 13});
            var infoWindow = new google.maps.InfoWindow;
            downloadUrl('http://rbtechsolution.com/truck_app/json_response.php?live_all_driver_api=Submit', function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName('marker');
                Array.prototype.forEach.call(markers, function(markerElem) {
                    var id = markerElem.getAttribute('id');
                    var name = markerElem.getAttribute('name');
                    var address = markerElem.getAttribute('truck');
                    var point = new google.maps.LatLng(
                        parseFloat(markerElem.getAttribute('lat')),
                        parseFloat(markerElem.getAttribute('lng')));
                    var infowincontent = document.createElement('div');
                    var strong = document.createElement('strong');
                    strong.textContent = name
                    infowincontent.appendChild(strong);
                    infowincontent.appendChild(document.createElement('br'));
                    var text = document.createElement('text');
                    text.textContent = address
                    infowincontent.appendChild(text);
                    var icon = customLabel["driver"] || {};
                    var image = {
                        url: './markerYellow.png',
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(0, 32)
                    };
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: image,
                        label: icon.label
                    });
                    marker.addListener('click', function() {
                        infoWindow.setContent(infowincontent);
                        infoWindow.open(map, marker);
                    });
                    markerss.push(marker);
                });
            });
        }
        if(selectedCountry!="select")
        {
            DeleteMarkers();
            var indore = {lat: 22.7196, lng: 75.8577};
            var map = new google.maps.Map(document.getElementById('map'), {center: indore,zoom: 13});
            var infoWindow = new google.maps.InfoWindow;
            downloadUrl('http://rbtechsolution.com/truck_app/json_response.php?manager_no='+selectedCountry+'&live_drive_under_mnager_api=Submit', function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName('marker');
                Array.prototype.forEach.call(markers, function(markerElem) {
                    var id = markerElem.getAttribute('id');
                    var name = markerElem.getAttribute('name');
                    var address = markerElem.getAttribute('truck');
                    var point = new google.maps.LatLng(
                        parseFloat(markerElem.getAttribute('lat')),
                        parseFloat(markerElem.getAttribute('lng')));
                    var infowincontent = document.createElement('div');
                    var strong = document.createElement('strong');
                    strong.textContent = name
                    infowincontent.appendChild(strong);
                    infowincontent.appendChild(document.createElement('br'));
                    var text = document.createElement('text');
                    text.textContent = address
                    infowincontent.appendChild(text);
                    var icon = customLabel["driver"] || {};
                    var image = {
                        url: './markerYellow.png',
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(0, 32)
                    };
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: image,
                        label: icon.label
                    });
                    marker.addListener('click', function() {
                        infoWindow.setContent(infowincontent);
                        infoWindow.open(map, marker);
                    });
                    markerss.push(marker);
                });
            });
        }
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };
        request.open('GET', url, true);
        request.send(null);
       }
    function doNothing() {}
    function DeleteMarkers() {
        for (var i = 0; i < markerss.length; i++) {
            markerss[i].setMap(null);
        }
        markerss = [];
    };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdFvXTNcn2V80lPvfSMEl1FuLegxJJNos&libraries=places&callback=initMap"></script>
  </body>
</html>