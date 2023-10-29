<?php
    require('connect.php');
    if(isset($_POST['function']) && $_POST['function'] == 'busID'){
        $id = $_POST['id'];
        $sql = "SELECT * FROM locations WHERE id LIKE {$id};";
        $query = mysqli_query($connection, $sql);
        $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
        foreach($rows as $value){
            echo "<option value=\"{$value['busStop']}\">{$value['busStop']}</option>";
        }
        exit();
    }
?>