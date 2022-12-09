<?php 
session_start();

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  echo "<script>window.location.href='../index';</script>";
}

?>


<!-- Sidebar -->
   <ul style="background: linear-gradient(45deg, #20cc8a,#4adda5);" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
<img   src="../Images/idsc.png" width="50rem;" height="50rem;">

  <div class=" mx-1" style="font-size: 1.2rem;">IDSC <sup>Hotel</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider w3-white">

<!-- Nav Item - Dashboard -->
<li class="nav-item  ">
  <a class="nav-link" href="index">
    <i class="fas fa-fw fa-home text-white" style="font-size: 1.1rem;"></i>
    <span style="font-size: 1rem; color: white;">Dashboard</span></a>
</li>

<!-- Divider -->
<!-- Divider -->
<hr class="sidebar-divider bg-white">
<!-- Heading -->
<div class="sidebar-heading">
  Interface
</div>

<!-- Nav Item - STaff Collapse Menu -->
<li class="nav-item">
  <a class="nav-link" href="../Staff/reservation">
    <i  style="font-size: 1.1rem;" class="fas fa-fw fa-calendar-check"></i>
    <span  style="font-size: 1rem;">Reservation</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider bg-white">

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link" href="../Staff/booking">
    <i  style="font-size: 1.1rem;" class="fas fa-fw fa-book"></i>
    <span style="font-size: 1rem;">Check in/out</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider bg-white">



<!-- Nav Item - STaff Collapse Menu -->
<li class="nav-item">
  <a class="nav-link" href="../Staff/billing">
    <i  style="font-size: 1.1rem;" class="fas fa-fw fa-users"></i>
    <span  style="font-size: 1rem;">Guest Folio</span></a>
</li>



<!-- Divider -->
<hr class="sidebar-divider bg-white">

<!-- Sidebar Toggler (Sidebar) -->


</ul>
<!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm   ">

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
                <span class="mr-2 d-none d-lg-inline w3-text-teal " style="font-size: 1rem;">
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
                
                <a class="dropdown-item" href="../Includes/logout.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->



  
