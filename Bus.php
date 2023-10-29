<!DOCTYPE html>
<html>
<head>
    <?php require('tool/header.php')?>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="module" src="index.js"></script>
    <style>
        #map {
            height: 100%;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <?php require 'tool/connect.php'; ?>
    <?php $id = mysqli_real_escape_string($connection, $_GET["value"]);
    $id = (int)$id;
    ?>
    <title>สายรถที่&nbsp; <?php echo $id; ?></title>
    <?php
    $sql = "SELECT * FROM location ";
    if($id == 0){
        $sql.= "WHERE `start-point` LIKE 0 ";
    }
    else {
    $sql .= "WHERE `id`  LIKE " . $id . " AND `start-point` LIKE 0 ";
    }
    $sql .= "ORDER BY id ASC;";
    $result = mysqli_query($connection, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    <span class="dropdown" id="dropdown">จุดขึ้น-ลง</span>
    <div><!--side-bar-bus-->
        <div class="select-point"> <!--selectpoint-->
            <ul id="end">
                <?php foreach ($rows as $row) : ?>
                    <li onclick="initMap(this)" id="fin" data-lat=<?php echo $row["lat"]; ?> data-lng=<?php echo $row["lng"]; ?>>
                        <?php echo $row["name"] ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <span id="duration">เวลาถึงป้าย : </span>
    <script>
        let dropdown2 = document.getElementById("dropdown");
        let change = false;

        function ChangeName() {
            if (change == false) {
                dropdown2.innerHTML = "ปิด";
                change = true;
            } else if (change == true) {
                dropdown2.innerHTML = "จุดขึ้น-ลง";
                change = false;
            }
        }
        dropdown2.addEventListener("click", ChangeName);
    </script>

    <a href="index.php" class="home">
        <ion-icon name="home-outline"></ion-icon>
    </a>

    <div id="map"></div>
    <script>
        var d = new Date();
        var save = document.getElementById("fin");
        var h = d.getHours();
        const start = [];
        const end = [];
        var x, y;
        var maps;
        var zoomnum = 14;
        var latnew = 14.0231939,
            lngnew = 100.6743812;
        var latnow = 14.0231939,
            lngnow = 100.6743812;
        var checkcenter = false;
        var checkmark = false;
        var marker;
        var lat,lng;
        end[0]=13.951722;
        end[1]=100.642611;
        var std = [];
        std[0]=0;
        std[1]=0;
        var latitu = []
        var size = latitu.length;
        var i=0;
        function loadmaps() {
            if(i<size){
            start[0]=latitu[i];
            start[1]=lngigu[i];
            i=i+1;
            }
            window.setInterval(function() {
                loadmaps();
            }, 1000);
        }
        loadmaps();
        var directionService, directionDisplay;

        function initMap() {
            directionService = new google.maps.DirectionsService;
            directionDisplay = new google.maps.DirectionsRenderer;
            var mapOptions = {
                center: {
                    lat: 14.0231939,
                    lng: 100.6743812
                },
                zoom: zoomnum,
            }
            checkmark = false;
            maps = new google.maps.Map(document.getElementById('map'), mapOptions);
            directionDisplay.setMap(maps);
            zoomnum = maps.getZoom();
            save = point;
            latnow = maps.getCenter().lat();
            lngnow = maps.getCenter().lng();
            calculateAndDisplayRoute(directionService, directionDisplay, lat, lng);
        }
        var j=0;
        window.setInterval(function() {
            if(start[0]!=std[0]||start[1]!=std[1]){
                j=j+1;
                calculateAndDisplayRoute(directionService, directionDisplay, lat, lng);
                std[0]=start[0];
                std[1]=start[1];
            }
        },1000);
        
        function calculateAndDisplayRoute(directionsService, directionsDisplay, lat, lng) {
            checkcenter = true;
            if(checkmark==true){
                marker.setMap(null);
            }
            checkmark = true;
            var icon = {
                url: "https://cdn.discordapp.com/attachments/826018094802796545/1110213904006647970/Pngtreeyellow_bus_icon_4432661.png",
                scaledSize: new google.maps.Size(100, 100),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(50, 70)
            }
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(start[0], start[1]),
            map: maps,
            icon: icon,
        });
            directionsService.route({
                origin: new google.maps.LatLng(start[0], start[1]),
                destination: new google.maps.LatLng(end[0],end[1]),
                travelMode: 'DRIVING',
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                    function time() {
                        document.getElementById('duration').innerHTML = "Duration : ";
                        let Hours = (parseInt(response.routes[0].legs[0].duration.value / 3600));
                        let Minutes = (parseInt((response.routes[0].legs[0].duration.value % 3600) / 60));
                        document.getElementById('duration').innerHTML += Hours + " hours " + Minutes + " minutes";
                    }
                    time();
                    response.routes[0].legs[0].duration.value/3600;
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            })
        }
        
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="main.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB30RFrSGvtHXMIorOJQkuWtQBtlM0ub6o&callback=initMap" async defer></script>
</body>

</html>