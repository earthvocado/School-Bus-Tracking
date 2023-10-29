<?php
    require('tool/connect.php');
    $id = $_POST['ID']; 
    $name = $_POST['Name']; 
    $surname = $_POST['Surname']; 
    date_default_timezone_set('Asia/Bangkok');
    $date_now = date("Y/m/d");
    $time_now = date("H:i:s");
    $sql = "SELECT * FROM userdata WHERE `userID` LIKE \"$id\";";
    $result = mysqli_query($connection,$sql);
    $rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
    echo $name;
    if($rows[0]['status']==1){
        $status = 0;
    }
    else{
        $status = 1;
    }
    $sql = "UPDATE `userdata` SET `status` = $status,`date` = \"$date_now\", `time` = \"$time_now\" WHERE `userID` = \"$id\";";
    if (mysqli_query($connection,$sql)){
        // echo "yes";
    }
?>