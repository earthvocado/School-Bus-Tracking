<?php
$pass = $_POST['pass'];
$conpass = $_POST['conpass'];
if ($pass === $conpass){
    echo "Password is corrected";
}
else {
    echo "Password is incorrect";
}
?>