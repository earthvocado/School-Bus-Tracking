<?php
    session_start();
    require('tool/connect.php');
    require('tool/header.php');
    $sql = "SELECT * FROM schoolbus;";
    $result = mysqli_query($connection, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <title>Register</title>
    <link rel="stylesheet" type = "text/css" href="StyleCSS/register.css">
    </head>
    <body>
        <div class="register-box">
            <div class = "SKR-brand">SKR</div>
            <div class = "sub-brand">BUS STATION</div>
            <div style="width:80%; height: 0px; stroke-width:2px; border: 1px #DDDDDD solid; margin:0 auto;"></div>
            <form class = "register-form" method = "post" action = "index.php">
                <div class="register-grid">
                    <div class="name-register">
                        <p style="font-size:2.5vh;">ชื่อ</p>
                        <input type="text" class="input-register" placeholder="ชื่อจริง" name="name" required>
                    </div>
                    <div class="lastname-register">
                        <p style = "font-size:2.5vh;">นามสกุล</p>   
                        <input type = "text" class = "input-register" placeholder="นามสกุล" name = "surname" inputmode ="numeric"required>  
                    </div>
                    <div class="userID-register">
                        <p style = "font-size:2.5vh;">เลขประจำตัว</p>    
                        <input type ="text" class = "input-register" maxlength="5" placeholder="11111" name="userID" required>
                    </div>
                    <div class ="busID-register">
                        <p style = "font-size:2.5vh;" class="register-bus-grid">สายรถ</p>
                        <select name="busID" id="busID" class = "input-register"required>
                            <option value="" selected disabled>เลือกสายรถ</option>
                            <?php foreach($rows as $value) : ?>
                            <option value="<?php echo $value["id"];?>"> <?php echo $value["id"];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class ="busStop-box">
                        <p style = "font-size:2.5vh;" class="register-stop-grid">จุดขึ้น-ลง</p>
                        <select name="busStop" id="busStop" class="input-register">
                            <option value="" selected disabled>เลือกจุดขึ้น-ลง</option>
                            
                            <!--หาจุดลงจากสายรถ-->
                            <script type="text/javascript">
                            $('#busID').change(function(){
                                var busID = this.value;
                                $.ajax({
                                    type: "post",
                                    url: "tool/ajax_register.php",
                                    data: {id:busID, function:'busID'},
                                    success: function(data){
                                        document.getElementById("busStop").innerHTML=data;
                                    }
                                });
                            });
                            </script>
                        </select>
                    </div>
                    <div class = "email-register">
                        <p style = "font-size:2.5vh;">Email</p>
                        <input type = "email" name="email" id ="email" class="input-register" required>
                    </div>
                    <div class = "password-register">
                        <p style = "font-size:2.5vh;">password</p>
                        <input type = "password" name="password" id = "password" class="input-register" require>
                        <br>
                        <div class ="check-pass-register"><input type = "checkbox" id = "show-pass"><label style = "font-size:2vh; margin:auto 0 auto 3%;">แสดงรหัสผ่าน</label></div>
                    </div>
                    <div class = "confirmpass-register">
                        <p style = "font-size:2.5vh;" class ="confirm-head">confirm password</p>
                        <input type="password" name="confirm-password" id="confirm-password" class="input-register" required>
                        <br>
                        <div class = "check-pass-register"><input type="checkbox" id="show-pass-con"><label style = "font-size:2vh; margin:auto 0 auto 3%;">แสดงรหัสผ่าน</label></div>
                        <p style = "font-size:2.5vh;" id="detectpass">Please Enter Password</p>
                    </div>
                        <!--โชว์password-->
                        <script>
                            $('#show-pass').change(function(){
                                if(this.checked){
                                    document.getElementById("password").type = "text";
                                }
                                else{
                                    document.getElementById("password").type = "password";
                                }
                            });
                            $('#show-pass-con').change(function(){
                                if(this.checked){
                                    document.getElementById("confirm-password").type = "text";
                                }
                                else{
                                    document.getElementById("confirm-password").type = "password";
                                }
                            });
                        </script>
                        <!--password check-->
                        <script>
                            $('#confirm-password,#password').change(function(){
                                var pass =document.getElementById("password").value;
                                var conpass = document.getElementById("confirm-password").value;
                                $.ajax({
                                    type : "post",
                                    url:"tool/checkpassword.php",
                                    data: {pass:pass,conpass:conpass},
                                    success:function(data){
                                        $("#detectpass").html(data);
                                    }
                                });
                            });
                        </script> 
                        <input class="regis-button" id="submit" value="ดำเนินการต่อ" type="button">
                </div>
                
                    <!-- email and password check -->
                <script>
                    $("#submit").click(function(){
                        var email = document.getElementById("email").value;
                        var pass = document.getElementById("password").value;
                        var conpass = document.getElementById("confirm-password").value;
                        $.ajax({
                            type:"post",
                            url:"tool/checkemail.php",
                            data: {email:email,pass:pass,conpass:conpass},
                            success:function(data){
                                if(data==0&&pass===conpass){
                                    if(document.getElementById("submit").type != "submit")
                                    Swal.fire(
                                    'โปรดตรวจสอบข้อมูลให้แน่ใจก่อนกดSubmitอีกครั้ง',
                                    '',
                                    'warning'
                                    );
                                    document.getElementById("submit").type = "submit";
                                }
                                else{
                                    alert("Emailนี้ถูกใช้ไปแล้วหรือรหัสผ่านของท่านไม่ตรงกัน");
                                }
                            }
                        });
                    });
                </script>
            </form>
        </div>
        <div class="return-to-login">
            <label style ="font-size:2vh;">มีบัญชีอยู่แล้วใช่ไหม</label>
            <a href="index.php" style="color:#0079FF;"><label style ="font-size:2vh;">กลับสู่หน้า login</label></a>
        </div>
    </body>
</html>