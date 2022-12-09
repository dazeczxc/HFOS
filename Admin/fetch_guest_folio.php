<?php

include('../Includes/conn_pdo.php');

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
SELECT * FROM guest WHERE GuestID IN (SELECT GuestID FROM recent_transaction)
";

if($_POST['query'] != '')
{
  $query .= '
  AND Name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ||
  Company LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ||
  Nationality  LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ||
  Address LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"

  ';



}

$query .= ' ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '

<div style="max-height: 500px;
overflow: auto;
width: 100%;
 display: inline-block;">
<table class="table  table-hover table-bordered" >
 
<tr  class="bg-info text-gray-100 " style="position: sticky; top: 0; z-index: 1; background: linear-gradient(225deg, #20cc8a,#4adda5);" >

 
<td class="d-none"> </td>
   <td >Guest Name </td>

  <td>Nationality</td>
  <td>Contact Number</td>
  <td>Email</td>

  <td>Home Address</td>
  <td>Company</td>
  <td>Address</td>

  </tr>
';
if($total_data > 0)
{
  foreach($result as $row)
  {
   
    


    $output .= '
    <tbody class="table-sm  ">
    <tr data-href="fetch_guest_transaction.php?guest_id='.$row["GuestID"].'" class="view_guest" id="'.$row["GuestID"].'" style="cursor: pointer">
      <td class="py-2"><a href="#" style="text-decoration: none;" class="text-gray-700 view_guest" id="'.$row["GuestID"].'">'.$row["Name"].'</a></td>
       <td class="py-2">'.$row["Nationality"].'</a></td>
      <td class="py-2" >'.$row["PNumber"].'</a></td>
      <td class="py-2" >'.$row["Email"].'</a></td>

      <td class="py-2" >'.$row["Address"].'</a></td>
      <td class="py-2">'.$row["Company"].'</a></td>
      <td class="py-2">'.$row["CompanyAddress"].'</a></td>

    
    </tr>
    ';
  }
}
else
{
  $output .= '
  <tr>
    <td colspan="8" align="center">No Data Found</td>
  </tr>
  </tbody>
  ';
}

$queryRoom = "SELECT SUM(TotalRates) As value_sum FROM recent_transaction";
$statement = $connect->prepare($queryRoom);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$sum = $result['value_sum'];

$output .= '
 
</table>
</div>
<div class="d-flex justify-content-lg-between">
<label class="text-gray-600">Total Records:  '.$total_data.'</label>
<div <align="center" style="margin-top: 10px;">
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
</div>
';




  echo $output;





?>  