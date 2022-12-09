<?php

include('../Includes/conn_pdo.php');


$limit = '12';
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
SELECT * FROM user 
";

if($_POST['query'] != '')
{
  $query .= '
  WHERE staffname LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ||
  username LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ||
  access LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" 

  ';
}

$query .= 'ORDER BY access ASC ';

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


    $hide = '
    <table class="  table-sm">
    <tr>
      <td class="d-none staff_id">'.$row["id"].'</td>
      <td><a href=""class="dropdown-item btn text-gray-700 delete_btn"><i class="fa fa-trash"></i> Delete</a>
      </td>
    </tr>
    </table>
      ';

 

    $output .= '
    <div class="col-xl-3 col-md-6 mb-4">';

      if($row['access'] == "Administrator"){
        $output .= '
      <div class="card border-left-info shadow h-100">';
    }else{
        $output .= '
      <div class="card border-left-success shadow h-100">';
    }

    $output .= '
            <div>
                <div class="mr-1 mt-1 w3-right dropdown no-arrow">
                    <a class="text-gray-500 dropdown-toggle btn" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">            
                    <i class="fa fa-ellipsis-v"> </i>           
                    </a>

                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow " aria-labelledby="userDropdown">
                        <a href="#"class="dropdown-item btn text-gray-700 view_data" id="'.$row["id"].'" ><i class="fa fa-user-secret " ></i> View Details</a>
                        <a href="#"class="dropdown-item btn text-gray-700 editbtn" id="'.$row["id"].'"><i class="fa fa-pen" ></i> Edit</a>
                        '.$hide.'
            
                    </div>
                </div>
            </div>

          <div class=" px-4 mb-4">

            

          <div class="row no-gutters align-items-center">
            <div class="col">';
            if($row['access'] == "Administrator"){
                                $output .= '
                                          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">'.$row["access"].'</div>';
                            }else{
                                $output .= '
                                       <div class="text-xs font-weight-bold text-success text-uppercase mb-1">'.$row["access"].'</div>';
                            }
                            $output .= '
              <div class="h6 mb-0 font-weight-bold text-gray-800">'.$row["staffname"].'</div>

              <div class=" mb-0  text-gray-600">'.$row["pnumber"].'</div>

            </div>
            <div class="col-auto mr-3">

                <img src="../Upload/User_Pics/'.$row["pic"].'" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px;"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    

    ';
  }
}
else
{
  $output .= '
  </div>
  
  <div class="container-fluid">

          <div class="text-center">
            <div class="error mx-auto" data-text="404">0</div>
            <p class="text-gray-600 mt-1 mb-3">No Data Found</p>
            <p class="text-gray-500 mb-0">Try searching other data...</p>
            
          </div>
          </div>


  
  
  ';
}

$output .= '

</div>

<div align="center" style="margin-top: 10px; margin-bottom: 1px;">
  <ul class="pagination">
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
';

echo $output;

?>

