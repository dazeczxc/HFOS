<?php
include("../Includes/conn.php");

$query = "SELECT * FROM amenities";
$run_query = mysqli_query($db, $query);

echo '<table class="table table-sm " style="font-size: 1.1rem;">
 
';

if(mysqli_num_rows($run_query) > 0){

    while ($row = mysqli_fetch_array($run_query)) {

        $out ='<tr>';
        $out .= '<td style="width: 80px;"><input type="number" name="amenities[]" min="0" value="0" class="form-control">
                 

         </select>
                 <td ><span>'.$row['AmenName'].'</span></td>
                 
                 </td>';
        $out .= '<td align="left" class=" "><span>&#8369 </span>'.$row['AmenRates'].'.00 /'.$row['AmenQuantity'].'</td>';
 
        $out .= '</tr>';
        echo $out;

    }
}
echo '</table>';

?>
