<?php 
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "id17863102_hotel";

	$db = new mysqli($host, $username, $password, $database);

    if($db->connect_error){
        echo $db->connect_error;
    }else{

    }
    ?>
