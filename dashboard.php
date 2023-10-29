<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="StyleCSS/dashboard.css">
    <?php
        require('tool/connect.php');
        require('tool/header.php');
    ?>
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
</head>

<body class="dashboard-body">
    <?php
        $sql = "SELECT * FROM locations WHERE `busStop`LIKE \"{$_SESSION["busStop"]}\" ORDER BY id ASC;";
        $result = mysqli_query($connection, $sql);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo "<script>var lat = {$rows[0]["lat"]},lng = {$rows[0]["lng"]};</script>";
    ?>
    <div class="navigation">
        <?php require('tool/navigation.php'); ?>
    </div>
    <div class="dashboard-main-box">
        <?php
        if ($_SESSION['name'] == null) {
            header("location:index.php");
        }
        ?>
        <div class="dashboard-head-box">
            <img src="image/headlogo.png" class="head-image">
            <?php echo "<p class='hello-user-text'>สวัสดี{$_SESSION['name']} {$_SESSION['surname']}</p>" ?>
        </div>
        <div class="information-outer">
            <p class="outer-head">ข้อมูลนักเรียน</p>
            <div class="information-inner">
                <div style="grid-area: 1/1/2/2; margin-bottom:10px;">
                    <?php echo "<p class=\"information-head\">รหัสประจำตัวนักเรียน</p><p class=\"information-user\">{$_SESSION['userID']}</p>" ?>
                </div>
                <div>
                    <?php echo "<p class=\"information-head\">สายรถ</p><p class=\"information-user\">{$_SESSION['busID']}</p>" ?>
                </div>
                <div style="grid-area: 2/1/3/3;">
                    <?php echo "<p class=\"information-head\">จุดขึ้น-ลง</p><p class=\"information-user\">{$_SESSION['busStop']}</p>"; ?>
                </div>
            </div>
        </div>
        <div class="dashboard-notification">
            <p class="outer-head">ศูนย์การแจ้งเตือน</p>
            <div class="sub-box">
                <div class="sub-sign" id="notification-sign"></div>
                <div class="sub-background" id="bus-where"></div>
            </div>
            <script>
                var x, y;
                $.getJSON("https://api.thingspeak.com/channels/2093164/fields/1/last.json?api_key=JX3SGT6TKMHMA824", function(result) {
                    x = result.field1;
                });
                $.getJSON("https://api.thingspeak.com/channels/2093164/fields/2/last.json?api_key=JX3SGT6TKMHMA824", function(result) {
                    y = result.field2;
                }).done(function() {
                    lat = parseFloat(lat);
                    lng = parseFloat(lng);
                    var directionService = new google.maps.DirectionsService;
                    directionService.route({
                        origin: new google.maps.LatLng(x, y),
                        destination: new google.maps.LatLng(lat, lng),
                        travelMode: 'DRIVING',
                    }, function(response, status) {
                        let Hours = (parseInt(response.routes[0].legs[0].duration.value / 3600));
                        let Minutes = (parseInt((response.routes[0].legs[0].duration.value % 3600) / 60));
                        if (Hours == 0 && Minutes == 0) {
                            document.getElementById("bus-where").innerHTML = "ถึงป้ายแล้ว";
                            document.getElementById("notification-sign").style.backgroundColor ="#F2A761";
                            document.getElementById("bus-where").style.backgroundColor ="#FFEAEA";
                        } else {
                            document.getElementById("bus-where").innerHTML = "จะถึงป้ายในอีก ";
                            if(Hours!=0){
                            document.getElementById("bus-where").innerHTML += Hours+" ชั่วโมง ";
                            }
                            document.getElementById("bus-where").innerHTML +=Minutes+" นาที";
                            document.getElementById("notification-sign").style.backgroundColor ="#F2A761";
                            document.getElementById("bus-where").style.backgroundColor ="#FCEDDF";
                        }
                    });
                });
            </script>
        </div>
        <div class ="rollcall-box">
            <p class="outer-head">การเช็คชื่อ</p>
            <div class="sub-box">
                <div class="sub-sign" id="rollcall-sign"></div>
                <div class="sub-background" id="where-you"></div>
                <div style ="display:grid; grid-template-columns: 60% 40%; grid-area:2/2/3/3;">
                <div style="grid-area:1/2/2/3;">
                    <label id = "date-rollcall"></label>
                    <label id = "time-rollcall"></label>
                </div>
                </div>
            </div>
        </div>
        <?php
            $sqlRollCall = "SELECT * FROM userdata WHERE `userID` LIKE '{$_SESSION["userID"]}';";
            $resultRollCall = mysqli_query($connection, $sqlRollCall);
            $rowsRollCall = mysqli_fetch_all($resultRollCall, MYSQLI_ASSOC);
            if($rowsRollCall[0]['status']==1){
                echo"<script>
                            document.getElementById(\"where-you\").innerHTML=\"อยู่บนรถบัส\";
                            document.getElementById(\"rollcall-sign\").style.backgroundColor =\"#76B752\";
                            document.getElementById(\"where-you\").style.backgroundColor =\"#EAFAE1\";
                    </script>";
            }
            else if ($rowsRollCall[0]['status']==0){
                echo"<script>
                        document.getElementById(\"where-you\").innerHTML=\"ไม่อยู่บนรถบัส\";
                        document.getElementById(\"rollcall-sign\").style.backgroundColor =\"#FF5454\";
                        document.getElementById(\"where-you\").style.backgroundColor =\"#FFEAEA\";
                    </script>";
            }
            echo "<script>document.getElementById(\"date-rollcall\").innerHTML=\"{$rowsRollCall[0]['date']}\"</script>";
            echo "<script>document.getElementById(\"time-rollcall\").innerHTML=\"{$rowsRollCall[0]['time']}\"</script>";
        ?>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB30RFrSGvtHXMIorOJQkuWtQBtlM0ub6o&callback=initMap" async defer></script>
</body>

</html>