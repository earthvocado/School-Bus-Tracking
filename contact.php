<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type = "text/css" href="StyleCSS/contact.css">
        <?php 
            require('tool/connect.php');
            require('tool/header.php');
        ?>
        <?php session_start()?>
        <title>Contact</title>
    </head>
    <body class = "contact-body">
        <div class="navigation">
            <?php require('tool/navigation.php'); ?>
        </div>
        <div class="contact-main-box">
            <?php
                if($_SESSION['name']==null){
                    header("location:index.php");
                }
            ?>
            <div class="contact-head-box">
                <img src="image/headlogo.png" class="head-image">
                <p class="contact-head-THname">ติดต่อเรา</p>
                <p class="contact-head-ENname">Contact Us</p>
            </div>
            <div class="contact-outer-box">
                <div class="JOKE">
                    <img src="image/joke.jpg" class="contact-image">
                    <p class="contact-name">นายณัฐพล บัวอุไร</p>
                    <p class="contact-duty">Project Manager</p>
                    <a href="mailto:15621@skr.ac.th" class="contact-gmail"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Gmail_icon_%282020%29.svg/2560px-Gmail_icon_%282020%29.svg.png" width="10%"></a>
                </div>
                <div class="PREM">
                    <img src="image/prem.jpg" class="contact-image">
                    <p class="contact-name">นายกีรติ เศรษฐสุข</p>
                    <p class="contact-duty">Web Developer</p>
                    <a href="mailto:15621@skr.ac.th" class="contact-gmail"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Gmail_icon_%282020%29.svg/2560px-Gmail_icon_%282020%29.svg.png" width="10%"></a>
                </div>
                <div class="TANYA">
                    <img src="image/tanya.jpg" class="contact-image">
                    <p class="contact-name">นางสาวณปภัช พรรณศิลป์</p>
                    <p class="contact-duty">Module Connector</p>
                    <a href="mailto:15621@skr.ac.th" class="contact-gmail"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Gmail_icon_%282020%29.svg/2560px-Gmail_icon_%282020%29.svg.png" width="10%"></a>
                </div>
                <div class="EARTH">
                    <img src="image/earth.jpg" class="contact-image">
                    <p class="contact-name">นางสาวณิชาพร อุทธยาน</p>
                    <p class="contact-duty">Web Developer</p>
                    <a href="mailto:15621@skr.ac.th" class="contact-gmail"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Gmail_icon_%282020%29.svg/2560px-Gmail_icon_%282020%29.svg.png" width="10%"></a>
                </div>
            </div>
        </div>
    </body>
</html>