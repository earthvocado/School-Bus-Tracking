<?php
    require('connect.php');
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $conpass = $_POST['conpass'];
        $sql = "SELECT * FROM userdata WHERE email LIKE {$email};";
        $result = mysqli_query($connection, $sql);
        $numrow = mysqli_num_rows($result);
        echo $numrow;
?>