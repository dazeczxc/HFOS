<?php 


 if(isset($_POST["staff_id"]))  
 {  
      $output = '';  
      include('../Includes/conn.php');
      $query = "SELECT * FROM user WHERE id = '".$_POST["staff_id"]."'";  
      $result = mysqli_query($db, $query);  
      
      $output .= '';
      while($row = mysqli_fetch_array($result))  
      {   
         $output .= 
        '<input type="hidden" name="id" value="'.$row['id'].'">

                        <div class="mb-3">
                            <label>Name</label>

                            <input type="text" name="staffname" value="'.$row['staffname'].'" class="form-control" placeholder="Last Name, First Name, MI." required>
                        </div>

                        <div class="mb-3">
                            <label>Phone Number</label>

                            <input type="text" name="pnumber" value="'.$row['pnumber'].'"  class="form-control" placeholder="Phone Number" required>
                        </div>

                        <div class="mb-3">
                            <label>Username</label>

                            <input type="text" name="username" value="'.$row['username'].'"  class="form-control" placeholder="Username" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>

                            <input type="text" name="password" value="'.$row['password'].'"  class="form-control" placeholder="Password" required>
                        </div>

                        <div class="mb-3">
                            <label for="UserType">User Type</label>
                            <select name="access" class="form-select" id="access">
                                 ';

                                 if ($row['access']=="Administrator"){
                                    $output .='<option selected value="Administrator">Administrator</option>
                                                <option value="Staff">Staff</option>';
                                    }else if ($row['access']=="Staff"){
                                        $output .='<option  value="Administrator">Administrator</option>
                                                    <option selected value="Staff">Staff</option>';
                                    }else{
                                        $output .='<option selected disabled >Select Access Type</option>

                                        <option value="Administrator">Administrator</option>
                                        <option value="Staff">Staff</option>';
                                        
                                    }
                                                               
                                $output .='
                            </select>               
                        </div>
                        
                        <div class="mb-3">
                            <label>Image</label>
                            <input value="'.$row['pic'].'"  type="file" name="StaffPic" id="StaffPic" class="form-control" required>
                        </div>
      '; 
      } 
      echo $output;
      mysqli_close($db);
  
 }  
 ?>