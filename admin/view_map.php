<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <style>
            p.poi {
               height: 100;
            }
        </style>
        <meta charset="UTF-8" />
        <title>Lavina | Edit Distributor's Discount</title>
        <link rel="icon" sizes="72x72" href="./images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style3.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5mBIyOR7BTYQtJ58ZSH7RbBvBG8BXg3Q&libraries=places" type="text/javascript"></script>
		<script type="text/javascript">
               function initialize() {
                    var input = document.getElementById('source');
                    var autocompletess = new google.maps.places.Autocomplete(input);
                    var inputs = document.getElementById('destination');
                    var autocompletes = new google.maps.places.Autocomplete(inputs);
               }
               google.maps.event.addDomListener(window, 'load', initialize);
       </script>
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
        include("../wp-config.php");
        $servername = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $dbname = DB_NAME;
        $unique=$_SESSION['email'] ;
        try 
        {   $message="";
            $conn = new mysqli($servername, $username, $password,$dbname);
            $end=$_SESSION["end"];
            if($end!="true"){
                echo '<script>
                        window.location="./adminLogin.php";
                    </script>';
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
                <p id="header" style="text-decoration:none">Email ID of Sales Person:- <?echo $unique?></p>
                <a id="header" style="text-decoration:none" href="./edit_details.php">Edit Sales person's Detail</a>
            </div>
        </div>
        <div id="map"></div>
        <script type="text/javascript">
                var markerss = [];
                var customLabel = {
                    driver: {
                      label: ''
                    },
                    manager: {
                      label: ''
                    }
                };
                $(document).ready(function(){
                    setInterval(function() {
                        DeleteMarkers();
                        initMap();
                    }, 2000);
                }); 
            
                function initMap() {
                    DeleteMarkers();
                    var infoWindow = new google.maps.InfoWindow;
                    downloadUrl('http://jobmafiaa.com/products/lavina/admin/json_response.php?email=<?=$unique?>&live_one_web=Submit', function(data) {
                        var xml = data.responseXML;
                        var markers = xml.documentElement.getElementsByTagName('marker');
                        Array.prototype.forEach.call(markers, function(markerElem) {
                            var email = markerElem.getAttribute('email');
                            var address = markerElem.getAttribute('address');
                            if(address==''){
                                address='Not assigned yet..!!';
                            }
                            var point = new google.maps.LatLng(
                                parseFloat(markerElem.getAttribute('lat')),
                                parseFloat(markerElem.getAttribute('lng')));
                            var map = new google.maps.Map(document.getElementById('map'), {center: point,zoom: 13});
                            var infowincontent = document.createElement('div');
                            var strong = document.createElement('strong');
                            strong.textContent = 'Sales Person\'s Email:- ' +email
                            infowincontent.appendChild(strong);
                            infowincontent.appendChild(document.createElement('br'));
                            var text = document.createElement('text');
                            text.textContent = 'Delivery Address:- '+address
                            infowincontent.appendChild(text);
                            var icon = customLabel["driver"] || {};
                            var image = {
                                url: 'https://jobmafiaa.com/products/lavina/admin/truck_app/admin/map/markerYellow.png',
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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5mBIyOR7BTYQtJ58ZSH7RbBvBG8BXg3Q&libraries=places&callback=initMap"></script>
    </body>
