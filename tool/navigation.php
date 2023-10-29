<!DOCTYPE html>
<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <?php 
        require('tool/connect.php');
    ?>
    <link rel="stylesheet" type = "text/css" href="StyleCSS/navigation.css">
    </head>
    <body class="navigation-body">
        <nav class="navigation-bar">
            <ul class="ul-navigation">
                <li class = "Brand-head">
                    <a href="dashboard.php" id = "hrefpage">
                        <p class="SKR-brand">SKR</p>
                        <p class="sub-brand">BUS STATION</p>
                    </a>
                </li>
                <li class="navigation-box">
                    <div class="dashboard-navigation">
                        <a href="dashboard.php" id="hrefpage">
                            <img src="image/home-icon.png" class="navigation-image">
                            <p class="navigation-head">หน้าหลัก</p>
                            <p class="sub-navigation-head">Dashboard</p>
                        </a>
                    </div>
                </li>
                <li class="navigation-box">
                    <div class="tracking-navigation">
                        <a href="Newtracking.php" id="hrefpage">
                        <img src="image/tracking-icon.png" class="navigation-image">
                        <p class="navigation-head">ติดตามรถ</p>
                        <p class="sub-navigation-head">Tracking Bus</p>
                    </a>
                    </div>
                </li>
                <li class="navigation-box">
                    <div class="contact-navigation">
                        <a href="contact.php" id = "hrefpage">
                            <img src="image/contact-icon.png" class="navigation-image">
                            <p class="navigation-head">ติดต่อเรา</p>
                            <p class="sub-navigation-head">Contact</p>
                        </a>
                    </div>
                </li>
                <li class = "navigation-box" id = "logout" onclick="deletesession();" >
                    <a href="index.php" id = "hrefpage">
                        <img src="image/logout-icon.png" class="navigation-image">
                        <p class="navigation-head" style="color:red">ออกจากระบบ</p>
                        <p class="sub-navigation-head" style="color:red">Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <script>
            if(window.innerWidth<=1080){
                document.getElementById("change-to-home").innerHTML = "Home";
            }
            function deletesession(){
                $.ajax({
                    type:"post",
                    url:"tool/checklogout.php",
                    success:function(data){
                    }
                });
            }
        </script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>