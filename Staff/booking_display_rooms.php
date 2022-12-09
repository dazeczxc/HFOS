<?php

include('../Includes/conn_pdo.php');


$limit = '100';
$page = 1;
if($_POST['page'] > 1)
{
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $start = 0;
}

$query = "
SELECT * FROM rooms 
";

if($_POST['query'] != '')
{
  $query .= '
  WHERE roomname LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"

  ';
}

$query .= 'ORDER BY RoomNumber ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '
    <div class="row  text-gray-800">
    ';

    if($total_data > 0)
    {
      foreach($result as $row)
      {
        $rID = $row["RoomID"];
        

        $stmt = $connect->prepare("SELECT * FROM transaction WHERE RoomID = $rID");
        $stmt->execute();
        $row_tran = $stmt->fetchAll();
        foreach($row_tran as $rowT){

          $to = $rowT['Departure'];

        $Departure = strtotime($to);
        $Departure2 = date('M d, Y', $Departure);
        }

        $rtypeid = $row['RoomType'];
        $stmt = $connect->prepare("SELECT * FROM roomtype WHERE roomtypeid = $rtypeid");
        $stmt->execute();
        $row_rtype = $stmt->fetchAll();
        foreach($row_rtype as $rowType){
        }
        
        $date_now = date("Y/m/d");
         
        $reserve_RoomID = '';
        $stmt_res = $connect->prepare("SELECT * FROM reservation WHERE RoomID = $rID AND ReservationStatus = 'Approved'  AND '$date_now' BETWEEN Arrival AND Departure" );
        $stmt_res->execute();
        $res_reserve = $stmt_res->fetchAll();
        foreach($res_reserve as $row_reserve){

        $reserve_RoomID = $row_reserve["RoomID"];
        
           
        }

        if(($row["RoomStatus"] == "Vacant") && ($row["RoomID"] = $reserve_RoomID)){
            $border = "border-left-info";
            $button ="btn btn-info";
            $text_white = " ";
            $info = '<b class="'.$text_white.'">Status: Reserved</b>';
            $button2 = '<a href="#"class="'.$button.' passroomid_btn py-1 col   view_data_reserve" id="'.$row["RoomID"].'" >View</a>';
            
        }else if(($row["RoomStatus"] == "Vacant") && empty($reserve_RoomID)){
            $border = "border-left-success";
            $button ="btn btn-success";
            $text_white = " ";
            $info = '<b class="'.$text_white.'">Status: Vacant</b>';
            $button2 = '<a href="booking_input_customer_info?roomid='.$rID.'" class="'.$button.' passroomid_btn  py-1 col">Book</a>';
        
            
        }else if($row["RoomStatus"] == "Booked"){
            $border = "border-left-warning";
            $button ="btn btn-warning";
            $text_white = "";
            $info = '<b class="'.$text_white.'">Out: '.$Departure2.'</b>';
            $button2 = '<a href="#"class="'.$button.' passroomid_btn py-1 col   view_data" id="'.$row["RoomID"].'" >View</a>';
        }


        
            $output .= '
              <div class="col-xl-2 mb-3">
                <div class="card '.$border.' shadow-sm text-gray-600" style="    border:.1rem solid rgba(0,0,0,.1);">
                      <div>
                        <div class="py-2 px-2 w3-left" style="font-size: 12px;"><b>'.$row["RoomNumber"].'</b></div>

                        <div class="d-none mr-1 mt-1 w3-right dropdown no-arrow">
                            <a class="text-gray-500 dropdown-toggle w3-hover-light-grey btn " href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">            
                            <i class="fa fa-ellipsis-v"> </i>           
                            </a>

                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow " aria-labelledby="userDropdown">
                            <a href="#"class="dropdown-item btn text-gray-700 view_data" id="'.$row["RoomID"].'" ><i class="fa fa-user-secret " ></i> View Details</a>
                               
                            <!-- <a href="#"class="dropdown-item btn text-gray-700 editbtn" id=""><i class="fa fa-pen" ></i> Edit</a> -->

                    
                        </div>
                      </div>
                    </div>

                    <div class="w3-center py-2 " style="font-size: 13px; font-weight: bold;">                        
                        <span class="d-none">'.$row["RoomName"].'</span><br>
                        '.$rowType["roomtype"].'    
                    </div>

                    <div class="pt-3 pb-3 px-2 w3-left" style="font-size: 12px;">'.$info.'</div>

                    <div class="text-center d-none d-md-inline mr-3 ml-3 mb-3">
                        
                        '.$button2.'

                    </div>

                </div>
              </div>';
      }
    }
else
{
  $output .= '
  </div>
  
    <div class="container-fluid">
        <div class="text-center">
            <div class="error mx-auto" data-text="">0</div>
            <p class="lead text-gray-800 mb-5">Room</p>
            <p class="text-gray-500 mb-0">Empty Room...</p>           
        </div>
    </div>
  ';
}


$output .= '

</div>

<!-- end of container -fluid from booking -->
</div>

<div class="  w3-bottom w3-white shadow-lg" >
    <div class="card w3-white ">
        <div align="center" style=" margin-top: 10px; margin-bottom: 1px;">
            <ul class="px-3 pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

//echo $total_links;

if($total_links > 4)
{
  if($page < 5)
  {
    for($count = 1; $count <= 5; $count++)
    {
      $page_array[] = $count;
    }
    $page_array[] = '...';
    $page_array[] = $total_links;
  }
  else
  {
    $end_limit = $total_links - 5;
    if($page > $end_limit)
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $end_limit; $count <= $total_links; $count++)
      {
        $page_array[] = $count;
      }
    }
    else
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $page - 1; $count <= $page + 1; $count++)
      {
        $page_array[] = $count;
      }
      $page_array[] = '...';
      $page_array[] = $total_links;
    }
  }
}
else
{
  for($count = 1; $count <= $total_links; $count++)
  {
    $page_array[] = $count;
  }
}


if($total_data > $limit){
for($count = 0; $count < count($page_array); $count++)
{
  if($page == $page_array[$count])
  {
    $page_link .= '
    <li class="page-item disabled">
      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
    </li>
    ';

    $previous_id = $page_array[$count] - 1;
    if($previous_id > 0)
    {
      $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
    }
    else
    {
      $previous_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Previous</a>
      </li>
      ';
    }
    $next_id = $page_array[$count] + 1;
    if($next_id > $total_links)
    {
      $next_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Next</a>
      </li>
        ';
    }
    else
    {
      $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
    }
  }
  else
  {
    if($page_array[$count] == '...')
    {
      $page_link .= '
      <li class="page-item disabled">
          <a class="page-link" href="#">...</a>
      </li>
      ';
    }
    else
    {
      $page_link .= '
      <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
      ';
    }
  }
}
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
            </ul>
        </div>
    </div>
</div>
';

echo $output;
