<?php
include('../Includes/header.php'); 
include('../Includes/navbar.php'); 

?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admin Panel</h1>
    <div class="mr-3 d-flex">
             <div class="mr-3">
                <?php
                $today = date('Y-m-d');

                 $date = strtotime($today);
                
                echo date('l,  F d, Y', $date);
                ?>
                </div>
                <div id="runningTime"></div>
             
        </div>
  </div>



<?php
include('../Includes/scripts.php');
include('../Includes/footer.php');
?>


        <script type="text/javascript">
$(document).ready(function() {
 setInterval(runningTime, 1000);
});
function runningTime() {
  $.ajax({
    url: 'timeScript.php',
    success: function(data) {
       $('#runningTime').html(data);
     },
  });
}
</script>




//buggy shit
		$query_delete = "SELECT * FROM amen_transaction WHERE  TransactionCode = '$TransactionCode'";
		$run_query_delete = mysqli_query($db, $query_delete);
		if(mysqli_num_rows($run_query_delete)>0){
			while($del_rows = mysqli_fetch_array($run_query_delete)){
				$idd = $del_rows['AmenID'];
				$segre_del = "DELETE FROM amen_transaction WHERE AmenID = $idd";
				$run_segre_del = mysqli_query($db, $segre_del);
			}
		}