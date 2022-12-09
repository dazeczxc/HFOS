<?php
include("../Includes/conn.php");

$Query = mysqli_query($db, "SELECT * FROM accommodation");

while ($rowtype = mysqli_fetch_array($Query)) {

    $out = '<option value="'.$rowtype["accommodationtype"].'"> '.$rowtype['accommodationtype'].'</option>';
    echo $out;

}


?>
