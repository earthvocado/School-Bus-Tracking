<!DOCTYPE html>
<html>
<head>
    <?php session_start(); ?>
    <link rel = "stylesheet" href = "StyleCSS/tracking.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="module" src="index.js"></script>
    <title>Tracking</title>
    <?php
    require ('tool/connect.php');
    require ('tool/header.php');
    ?>
</head>

<body class="tracking-body">
    <div>
        <?php require('tool/navigation.php')?>
    </div>
    <div class="tracking-main-box">
        <?php
            if($_SESSION['name']==null){
                header("location:index.php");
            }
        ?>
        <div class="tracking-head-box">
            <img src="image/headlogo.png" class="head-image">
            <p class="tracking-head-THname">ติดตามรถรับส่ง</p>
            <p class="tracking-head-ENname">Bus tracking center</p>
        </div>
        <div>
            <div id="map"></div>
            <div class="tracking-report">
                <?php echo"<label class=\"tracking-report-head\">สายรถ {$_SESSION['busID']}</label>"?><br>
                <div class="report-detail">
                    <label>เวลาก่อนจะถึงคุณ </label><label id="duration"></label><label class = "ensp">&ensp;&ensp;&ensp;&ensp;&ensp;</label><br>
                    <label>ระยะทางจากจุดรับ-ส่งนักเรียน </label><label id="dis-to-point"></label><label class = "ensp">&ensp;&ensp;&ensp;&ensp;&ensp;</label><br>
                    <label id = "dis-school" style = "display:none;"> </label><label id="dis-to-school"></label>
                </div>
            </div>
        </div>
    </div>
    <?php
        $sql = "SELECT * FROM locations WHERE `busStop`LIKE \"{$_SESSION["busStop"]}\" ORDER BY id ASC;";
        $result = mysqli_query($connection,$sql);
        $rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
        echo "<script>var lat = {$rows[0]["lat"]},lng = {$rows[0]["lng"]};</script>";
    ?>
    <script>
        var d = new Date();
        var h = d.getHours();
        const start = [];
        const end = [];
        const std = [];
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
        var gendirec = false;
        function loadmaps() {
            var m;
            $.getJSON("https://api.thingspeak.com/channels/2093164/fields/1/last.json?api_key=JX3SGT6TKMHMA824", function(result) {
                m = result;
                x = Number(m.field1);
            });
            $.getJSON("https://api.thingspeak.com/channels/2093164/fields/2/last.json?api_key=JX3SGT6TKMHMA824", function(result) {
                m = result;
                y = Number(m.field2);

            }).done(function() {
                if (x == undefined || y == undefined) {
                    loadmaps();
                    return 0;
                }
                std[0] = start[0];
                std[1] = start[1];
                start[0] = x;
                start[1] = y;
                end[0] = 14.023376053762808;
                end[1] = 100.6765484395249;
            });
            window.setInterval(function() {
                loadmaps();
            }, 60000); 
        }
        loadmaps();
        var directionService, directionDisplay;
        lat = parseFloat(lat);
        lng = parseFloat(lng);
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
            window.setInterval(function() {
                var checkzoom = maps.getZoom();
                var checkpos = maps.getCenter();
                var checklat = checkpos.lat();
                var checklng = checkpos.lng();
                if (zoomnum != checkzoom && checkzoom != 14 && checkcenter == false) {
                    zoomnum = checkzoom;
                }
                if ((latnew != checklat || lngnew != checklng) && (checklat != latnow && checklng != lngnow) && checkcenter == false) {
                    latnew = checklat;
                    lngnew = checklng;
                }
            });
            latnow = maps.getCenter().lat();
            lngnow = maps.getCenter().lng();
            setTimeout(function(){
            calculateAndDisplayRoute(directionService, directionDisplay);
            }
            ,1000);
        }
        window.setInterval(function(){
            calculateAndDisplayRoute(directionService, directionDisplay);
        },10000);
        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
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
        if (h <= 12) {
            directionsService.route({
                origin: new google.maps.LatLng(start[0], start[1]),
                waypoints: [{
                    location: new google.maps.LatLng(lat, lng)
                }],
                destination: new google.maps.LatLng(end[0], end[1]),
                travelMode: 'DRIVING',
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                    setTimeout(function() {
                        if(gendirec){
                        maps.setZoom(zoomnum);
                        maps.setCenter(new google.maps.LatLng(latnew, lngnew));
                        checkcenter = false;
                        gendirec=true;
                        }
                    }, 10);
                    document.getElementById("dis-to-point").innerHTML=parseInt(response.routes[0].legs[0].distance.value/1000)+" กิโลเมตร";
                    function time() {
                        let Hours = (parseInt(response.routes[0].legs[0].duration.value / 3600));
                        let Minutes = (parseInt((response.routes[0].legs[0].duration.value % 3600) / 60));
                        document.getElementById('duration').innerHTML="";
                        if(Hours!=0)document.getElementById('duration').innerHTML = Hours + " ชั่วโมง ";
                        document.getElementById('duration').innerHTML +=  Minutes + " นาที";
                    }
                    time();
                }
                else{
                calculateAndDisplayRoute(directionsService, directionsDisplay);
                }
            })
            directionService.route({
            origin: new google.maps.LatLng(start[0], start[1]),
            destination: new google.maps.LatLng(end[0], end[1]),
            travelMode: 'DRIVING',
        },function(response, status){
            document.getElementById("dis-school").innerHTML = "ระยะทางจากโรงเรียน ";
            document.getElementById("dis-to-school").innerHTML=parseInt(response.routes[0].legs[0].distance.value/1000)+" กิโลเมตร";
            document.getElementById("dis-school").style.display="inline";

        });
        } else if (h > 12) {
            directionsService.route({
                origin: new google.maps.LatLng(start[0], start[1]),
                destination: new google.maps.LatLng(lat, lng),
                travelMode: 'DRIVING',
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                    setTimeout(function() {
                        if(gendirec==true){
                        maps.setZoom(zoomnum);
                        maps.setCenter(new google.maps.LatLng(latnew, lngnew));
                        checkcenter = false;
                        gendirec=true;
                        }
                    },10);
                    document.getElementById("dis-to-point").innerHTML=parseInt(response.routes[0].legs[0].distance.value/1000)+" กิโลเมตร";
                    function time() {
                        let Hours = (parseInt(response.routes[0].legs[0].duration.value / 3600));
                        let Minutes = (parseInt((response.routes[0].legs[0].duration.value % 3600) / 60));
                        document.getElementById('duration').innerHTML="";
                        if(Hours!=0)document.getElementById('duration').innerHTML = Hours + " ชั่วโมง ";
                        document.getElementById('duration').innerHTML +=  Minutes + " นาที";
                    }
                    time();
                }
                else{
                    calculateAndDisplayRoute(directionsService, directionsDisplay);
                }
        });
        }
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="tool/main.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB30RFrSGvtHXMIorOJQkuWtQBtlM0ub6o&callback=initMap" async defer></script>
</body>

</html>