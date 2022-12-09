<?php

include('../Includes/conn_pdo.php');


$limit = '10';
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
SELECT * FROM guest WHERE GuestID IN(SELECT guestID FROM recent_transaction)
";

if($_POST['query'] != '')
{
  $query .= '
  AND Name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
  
 

  ';
}

$query .= 'ORDER BY GuestID ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '

<table class="table table-sm   ">
<tr class="bg-success text-white">
                      <td class="py-2">Name</td>
                      <td class="py-2">Nationality</td>
 
                      <td class="py-2">Address</td>
                      <td class="py-2">Company</td>

                      <td style="width: 100px;" class=" w3-center py-2">Action</td>
                    </tr>                   
';
if($total_data > 0)
{
  foreach($result as $row)
  {
 
    $output .= '
    <tbody class="table-sm">

    <tr>
      <td class="py-2 d-none">'.$row["GuestID"].'</td>
      <td class="py-2 d-none">'.$row["Name"].'</td>
      <td class="py-2 d-none">'.$row["Nationality"].'</td>
      <td class="py-2 d-none">'.$row["Birthdate"].'</td>
      <td class="py-2 d-none">'.$row["PNumber"].'</td>
      <td class="py-2 d-none">'.$row["Email"].'</td>
      <td class="py-2 d-none">'.$row["Address"].'</td>
      <td class="py-2 d-none">'.$row["Company"].'</td>
      <td class="py-2 d-none">'.$row["CompanyAddress"].'</td>
      <td class="py-2 d-none">'.$row["Origin"].'</td>
      <td class="py-2 d-none">'.$row["Passport"].'</td>
      <td class="py-2 d-none">'.$row["IssuedAt"].'</td>

      <td class="pt-3">'.$row["Name"].'</td>
      <td class="pt-3">'.$row["Nationality"].'</td>
       <td class="pt-3">'.$row["Address"].'</td>
      <td class="pt-3">'.$row["Company"].'</td>

 

      <td style="width: 120px;" class="py-2 w3-center">
        <button class="btn btn-success px-4 selectbtn" data-bs-dismiss="modal" aria-label="Close">Select</button>
                    
    </td>

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

$output .= '
</table>
<div class="d-flex justify-content-lg-between">
<label class="text-gray-600">Total Records:  '.$total_data.'</label>

<div <align="center">
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