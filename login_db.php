<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
    <?php 
        session_start();
        require('tool/connect.php');
        $errors = array();
        if(isset($_POST['login-btn'])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            if(count($errors) == 0){
                $query = "SELECT * FROM userdata WHERE email='$email';";
                $result = mysqli_query($connection, $query);
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                if(mysqli_num_rows($result) == 1&&password_verify($password,$rows[0]['password'])){
                    $_SESSION['userID'] = $rows[0]['userID'];
                    $_SESSION['busStop'] = $rows[0]['busStop'];
                    $_SESSION['busID'] = $rows[0]['busID'];
                    $_SESSION['name']=$rows[0]['name'];
                    $_SESSION['surname']=$rows[0]['surname'];
                    header("location:dashboard.php");
                }
                else{
                    array_push($errors, "ตรวจสอบข้อมูลใหม่นะจ๊ะ อิอิ");
                    $_SESSION['error'] = "e";
                    header("location: index.php");
                }
            }
        }
    ?>
</body>
</html>