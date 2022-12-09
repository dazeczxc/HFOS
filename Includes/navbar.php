<?php 
session_start();

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  echo "<script>window.location.href='../index';</script>";
}

?>


<!-- Sidebar -->
   <ul style="background: linear-gradient(45deg, #20cc8a,#4adda5);" class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
<img   src="../Images/idsc.png" width="50rem;" height="50rem;">

  <div class=" mx-1" style="font-size: 1.2rem;">IDSC <sup>Hotel</sup></div>
</a>

<!-- Divider -->
<!-- Divider -->
<hr class="sidebar-divider bg-white">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="billing">
    <i class="fas fa-fw fa-home text-white"  style="font-size: 1.1rem;"></i>
    <span  style="font-size: 1rem;" class="text-white">Home</span></a>
</li>

<!-- Divider -->
<!-- Divider -->
<hr class="sidebar-divider bg-white">
<!-- Heading -->
<div class="sidebar-heading">
  Interface
</div>




<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link" href="roomtype">
    <i class="fas fa-fw fa-th-list" style="font-size: 1.1rem;"></i>
    <span  style="font-size: 1rem;">Room Types</span></a>
</li>
<!-- Divider -->
<!-- Divider -->
<hr class="sidebar-divider bg-white">

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link" href="room">
    <i class="fas fa-fw fa-door-open" style="font-size: 1.1rem;"></i>
    <span  style="font-size: 1rem;">Rooms</span></a>
</li>



<!-- Divider -->
<hr class="sidebar-divider bg-white">

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link" href="amenities">
    <i class="fas fa-fw fa-building" style="font-size: 1.1rem;"></i>
    <span  style="font-size: 1rem;">Amenities</span></a>
</li>

 



<!-- Divider -->
<!-- Divider 
<hr class="sidebar-divider bg-white">

<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
    <i class="fas fa-fw fa-wrench"></i>
    <span>Room Utilities</span>
  </a>
  <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Room Utilities:</h6>
      <a class="collapse-item" href="../Admin/roomtype">Room Types</a>
      <a class="collapse-item" href="../Admin/accommodation">Accommodation</a>
    </div>
  </div>
</li>
-->
<!-- Divider -->
<!-- Divider -->
<hr class="sidebar-divider bg-white">
<!-- Nav Item - STaff Collapse Menu -->
<li class="nav-item">
  <a class="nav-link" href="staff">
    <i class="fas fa-fw fa-user-cog" style="font-size: 1.1rem;"></i>
    <span  style="font-size: 1rem;">Staff Mngt</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider bg-white">
<!-- Nav Item - STaff Collapse Menu -->
<li class="nav-item">
  <a class="nav-link" href="billing">
    <i class="fas fa-fw fa-server" style="font-size: 1.1rem;"></i>
    <span  style="font-size: 1rem;">Transactions</span></a>
</li>


<!-- Divider -->
<!-- Divider -->
<hr class="sidebar-divider bg-white">

</ul>
<!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
         

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline w3-text-teal"  style="font-size: 1rem;">
                  <?php
                  echo $_SESSION['staffname'];
                  ?>
              
                  
                </span>
                <img class="img-profile rounded-circle" src="../Upload/User_Pics/<?php
                  echo $_SESSION['staffpic'];
?>">
              </a>

              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <a class="dropdown-item" href="../Includes/logout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

 

  
