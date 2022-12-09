<?php  
 if(isset($_POST["staff_id"]))  
 {  
      $output = '';  
      include('../Includes/conn.php');
      $query = "SELECT * FROM user WHERE id = '".$_POST["staff_id"]."'";  
      $result = mysqli_query($db, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  

          
            $output .= '  
                <tr>  
                     <td width="30%"><label>Name</label></td>  
                     <td width="70%">'.$row["staffname"].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Phone Number</label></td>  
                     <td width="70%">'.$row["pnumber"].'</td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Username</label></td>  
                     <td width="70%">'.$row["username"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Password</label></td>  
                     <td width="70%">'.$row['password'].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>User Type</label></td>  
                     <td width="70%">'.$row["access"].'</td>  
                </tr>  
                 
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
      mysqli_close($db);

 }  
 ?>