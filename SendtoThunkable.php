<!DOCTYPE html>
<html>
    <head>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    </head>
    <body>   
    <?php
    require("tool/connect.php");
    ?>
        <?php 
        session_start();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        $sql = "SELECT * FROM userdata WHERE `userID` LIKE '{$id}';";
        $result = mysqli_query($connection,$sql);
        $rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
        echo "<script>var lat = {$rows[0]["lat"]},lng = {$rows[0]["lng"]},id = {$id};</script>";
        ?>
    <p id = "time"></p>
    <script>
        var x,y;
    $.getJSON("https://api.thingspeak.com/channels/2093164/fields/1/last.json?api_key=JX3SGT6TKMHMA824",function(result){
        x = result.field1;
    });
    $.getJSON("https://api.thingspeak.com/channels/2093164/fields/2/last.json?api_key=JX3SGT6TKMHMA824",function(result){
        y = result.field2;
    }).done(function(){
        lat = parseFloat(lat);
        lng = parseFloat(lng);
        id = parseInt(id);
        var directionService = new google.maps.DirectionsService;
        directionService.route({
            origin: new google.maps.LatLng(x, y),
            destination: new google.maps.LatLng(lat, lng),
            travelMode: 'DRIVING',
        },function(response, status){
            let Hours = (parseInt(response.routes[0].legs[0].duration.value / 3600));
            let Minutes = (parseInt((response.routes[0].legs[0].duration.value % 3600) / 60));
            document.getElementById("time").innerHTML = `{"hours":${Hours},"minutes":${Minutes},"id":${id}}`;
        });
    });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB30RFrSGvtHXMIorOJQkuWtQBtlM0ub6o&callback=initMap" async defer></script>    
    </body>
</html>