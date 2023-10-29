<?php
require('tool/connect.php');
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <?php require('tool/header.php')?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" type = "text/css" href="StyleCSS/login.css">
    <title>Login</title>
</head>

<body>
    <?php
    if($_SESSION['error']=="e"){
        echo "
            <script>
            Swal.fire(
            'ERROR',
            'โปรดตรวจสอบข้อมูลอีกครั้ง',
            'error'
            );
            </script>";
    }
    if($_SESSION['name']!=null){
        header("location:dashboard.php");
    }
    ?>
    <img class="bus-img" src="image/bus-background.jpg">
    <div class="login-box">
        <div class="SKR-brand">SKR</div>
        <div class="sub-brand">BUS STATION</div>
        <div style="width: 90%; height: 0px; border: 2px #DDDDDD solid; margin-left:5%;"></div>
        <form action="login_db.php" method="post" class="form-login">
            <?php //require('error.php') ?>
            <p class ="email">อีเมล</p>
            <input type ="email" class = "email-input" placeholder="รหัสประจำตัวนักเรียน@skr.ac.th" name="email">
            <p class = "password">รหัสผ่าน</p>
            <input type="password" class="password-input" placeholder="Password" name="password">
            <button type="submit" name="login-btn" class="login-btn">เข้าสู่ระบบ</button>
            
            <div class= "regis-box">
                <label class = "regis-text">ยังไม่ลงทะเบียนสายรถใช่ไหม?</label>
                <a class = "regis" href="register.php">ลงทะเบียนเลย</a>
            </div>
        </from>
    </div>
    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = mysqli_real_escape_string($connection, $_POST["name"]);
            $surname = mysqli_real_escape_string($connection, $_POST["surname"]);
            $userID = mysqli_real_escape_string($connection, $_POST["userID"]);
            $busID = mysqli_real_escape_string($connection, $_POST["busID"]);
            $busStop = mysqli_real_escape_string($connection, $_POST["busStop"]);
            $email = mysqli_real_escape_string($connection, $_POST["email"]);
            $password = mysqli_real_escape_string($connection, $_POST["password"]);
            $password_hashed = mysqli_real_escape_string($connection, password_hash($password,PASSWORD_DEFAULT));
            $sql = "SELECT * FROM locations WHERE `busStop`LIKE \"{$busStop}\" ORDER BY id ASC;";
            $result = mysqli_query($connection,$sql);
            $rows =mysqli_fetch_all($result,MYSQLI_ASSOC);
            $lat = $rows[0]['lat'];
            $lng = $rows[0]['lng'];
            $sql = "INSERT INTO userdata (`name`, `surname`, `userID`, `busID`, `busStop`, `email`, `password`,`lat`,`lng`) VALUES('$name','$surname','$userID','$busID','$busStop','$email','$password_hashed','$lat','$lng');";
            mysqli_query($connection,$sql);    
        }
    ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/cc09c47b01.js" crossorigin="anonymous"></script>

</body>

</html>