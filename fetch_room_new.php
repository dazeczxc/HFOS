<?php

include('Includes/conn_pdo.php');
include('Includes/conn.php');


$limit = '1000';
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
SELECT * FROM roomtype WHERE roomtypeid IN(SELECT RoomType FROM rooms)
";

if($_POST['query'] != '')
{
  $query .= '
  AND roomtype LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
   
  ';
}

$query .= 'ORDER BY roomtypeid ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '
 <div class="row">
';
if($total_data > 0)
{
  foreach($result as $row)
  {

    $rType = $row['roomtypeid'];

    $room_type = "SELECT * FROM rooms WHERE RoomType = '$rType'";
    $run_room_type = mysqli_query($db, $room_type);
    $row_type = mysqli_fetch_assoc($run_room_type);

    $query_t = "SELECT COUNT(Star) AS total FROM rating WHERE RoomID = $rType";
    $run_query_t = mysqli_query($db, $query_t);                               
    $row_sumt = mysqli_fetch_assoc($run_query_t);

    if($row_sumt['total'] > 0){
        $query_sum = "SELECT SUM(Star) AS rating FROM rating WHERE RoomID = $rType";
        $run_query_sum = mysqli_query($db, $query_sum);
        $row_sum = mysqli_fetch_assoc($run_query_sum);

        $total = $row_sumt['total'];
        $total_rate = $row_sum['rating'];

        $rating = $total_rate/$total;
        
        $rounded = '<b>'.round($rating ,2).' / 5 <i class="fas fa-star star-warning mr-1 main_star"></i></b>';

    }else{
        $rounded =' <i class="fas fa-star star-warning mr-1 main_star"></i> No Ratings ';

    }
    

    $output .= '
        <div class="col-lg-4 pt-4">
                    <div class="card shadow-sm">
                        <div class="card-img-top"><img src="Upload/'.$row_type["RoomImage"].'" alt="image" width="100%;" height="250px;"></div>
                        <div class=" card-body">

                        <div class="">
                                                    <h5 class="text-warning  mb-4">
                                                    '.$rounded.'
                                                    </h5>
                                                 </div>


                            <div class="text-success pb-2" style="font-size: 1.1rem;">'.$row['roomtype'].'</div>
                            <div class="pb-4" style="font-size: 1rem; height: 70px; overflow: hidden;">
                            
                            <p class="card-text">'.$row['roomtypedescription'].'</p>

                            </div>


                            <a  href="room_details?roomidko='.$row_type['RoomID'].'" class="card-link text-success mr-3">View Full Details</a>

                                                    
                         
                        </div>

                        
                    </div>
                </div>

    
    ';
  }
}
else
{
  $output .= '
   
  ';
}

 

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
';

echo $output;

?>