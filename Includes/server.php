<?php

if (!isset($_SESSION)) {
	session_start();
}

include("conn.php");

//Rooms-------------------------------------------------------------------------
 
if (isset($_POST['save'])) {
 	$RoomNumber = $_POST['RoomNumber'];
	
	$RoomType = $_POST['RoomType'];
	$RoomImage = $_FILES["RoomImage"]['name'];
	$RoomStatus = $_POST["RoomStatus"];


	$query_Room_Save = "INSERT INTO rooms ( RoomNumber, RoomType, RoomImage, RoomStatus) VALUES ('$RoomNumber', '$RoomType', '$RoomImage','$RoomStatus')";
	$query_run_query_Room_Save = mysqli_query($db, $query_Room_Save);

	if ($query_run_query_Room_Save) {
		move_uploaded_file($_FILES["RoomImage"]["tmp_name"], "../Upload/" . $_FILES["RoomImage"]["name"]);
		$_SESSION['RoomMessage'] = '
			
				<div class="alert alert-success alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Room added successfully!</h5>
				</div>
			
			';
			echo "<script>window.location.href='../Admin/room';</script>";

		 
	} else {
		$_SESSION['RoomMessage'] = '
				<div class="alert alert-danger alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Some error occured, please try again!</h5>
				</div>

			';

			echo "<script>window.location.href='../Admin/room';</script>";
	}
}


if (isset($_POST['edit'])) {
	$RoomID = $_POST['RoomID'];
	$RoomNumber = $_POST['RoomNumber'];
	
	$RoomType = $_POST['RoomType'];
	$RoomImage = $_FILES["RoomImage"]['name'];
	$RoomStatus = $_POST["RoomStatus"];


	$query_Room_Edit = "UPDATE rooms SET RoomNumber='$RoomNumber', RoomType='$RoomType', RoomImage='$RoomImage', RoomStatus='$RoomStatus' WHERE RoomID=$RoomID";
	$query_run_query_Room_Edit = mysqli_query($db, $query_Room_Edit);

	if ($query_run_query_Room_Edit) {
		move_uploaded_file($_FILES["RoomImage"]["tmp_name"], "../Upload/" . $_FILES["RoomImage"]["name"]);
		$_SESSION['RoomMessage'] = '
			
				<div class="alert alert-success alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Room updated successfully!</h5>
				</div>
			
			';
			echo "<script>window.location.href='../Admin/room';</script>";
	} else {
		$_SESSION['RoomMessage'] = '
				<div class="alert alert-danger alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Some error occured, please try again!</h5>
				</div>

			';

			echo "<script>window.location.href='../Admin/room';</script>";
	}
}

if (isset($_POST['del'])) {
	$RoomID = $_POST['RoomID'];
	$query_Room_Delete = "DELETE FROM rooms WHERE RoomID=$RoomID";
	$query_run_query_Room_Delete = mysqli_query($db, $query_Room_Delete);

	if ($query_run_query_Room_Delete) {
		$_SESSION['RoomMessage'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Room deleted successfully!</h5>
		</div>
	
	';

	echo "<script>window.location.href='../Admin/room';</script>";
	} else {
		$_SESSION['RoomMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Admin/room';</script>";
	}

	mysqli_close($db);
}

 

//userss ----------------------------------------------------

if (isset($_POST['staffsave'])) {

 	$StaffName = $_POST['staffname'];
	$StaffNumber = $_POST['pnumber'];
	$StaffUsername = $_POST['username'];
	$StaffPassword = $_POST['password'];
	//$StaffPassword = md5($StaffPassword);
	$StaffAccess = $_POST['access'];
	$StaffPic = $_FILES["StaffPic"]['name'];

	$query_Staff_Save = "INSERT INTO user (staffname, pnumber, username, password, access, pic) VALUES ('$StaffName','$StaffNumber', '$StaffUsername','$StaffPassword','$StaffAccess', '$StaffPic')";
	$query_run_query_Staff_Save = mysqli_query($db, $query_Staff_Save);

	if ($query_run_query_Staff_Save) {
		move_uploaded_file($_FILES["StaffPic"]["tmp_name"], "../Upload/User_Pics/" . $_FILES["StaffPic"]["name"]);
		$_SESSION['StaffMessage'] = '
			
					<div class="alert alert-success alert-dismissable" id="flash-msg">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<h5>Staff created successfully!</h5>
					</div>
				';

 		echo "<script>window.location.href='../Admin/staff';</script>";
	} else {
		$_SESSION['StaffMessage'] = '
			
					<div class="alert alert-danger alert-dismissable" id="flash-msg">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<h5>Some error occured, please try again!</h5>
					</div>

				';
				echo "<script>window.location.href='../Admin/staff';</script>";

	}
}


if (isset($_POST['staffedit'])) {
	$StaffID = $_POST['id'];
	$StaffName = $_POST['staffname'];
	$StaffNumber = $_POST['pnumber'];
	$StaffUsername = $_POST['username'];
	$StaffPassword = $_POST['password'];
	//$StaffPassword = md5($StaffPassword);
	$StaffAccess = $_POST['access'];
	$StaffPic = $_FILES["StaffPic"]['name'];

	$query_Staff_Edit = "UPDATE user SET staffname='$StaffName', pnumber='$StaffNumber', username='$StaffUsername', password='$StaffPassword', access='$StaffAccess', pic='$StaffPic' WHERE id=$StaffID";
	$query_run_query_Staff_Edit = mysqli_query($db, $query_Staff_Edit);

	if ($query_run_query_Staff_Edit) {
		move_uploaded_file($_FILES["StaffPic"]["tmp_name"], "../Upload/User_Pics/" . $_FILES["StaffPic"]["name"]);
		$_SESSION['StaffMessage'] = '
			
					<div class="alert alert-success alert-dismissable" id="flash-msg">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<h5>Staff updated successfully!</h5>
					</div>
				';
				echo "<script>window.location.href='../Admin/staff';</script>";

	} else {
		$_SESSION['StaffMessage'] = '
			
			<div class="alert alert-danger alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Some error occured, please try again!</h5>
			</div>

		';
		echo "<script>window.location.href='../Admin/staff';</script>";

	}
}

if (isset($_POST['staffdel'])) {
	$StaffID = $_POST['staffID'];
	$query_Staff_Delete = "DELETE FROM user WHERE id = $StaffID";
	$query_run_query_Staff_Delete = mysqli_query($db, $query_Staff_Delete);

	if ($query_run_query_Staff_Delete) {
		$_SESSION['StaffMessage'] = '
			
					<div class="alert alert-success alert-dismissable" id="flash-msg">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<h5>Staff Deleted Successfully!</h5>
					</div>
				';
				echo "<script>window.location.href='../Admin/staff';</script>";

	} else {
		$_SESSION['StaffMessage'] = '
			
			<div class="alert alert-danger alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Some error occured, please try again!</h5>
			</div>

		';
		echo "<script>window.location.href='../Admin/staff';</script>";

	}
	mysqli_close($db);
}



//roomtype ----------------------------------------------------

if (isset($_POST['roomtypesave'])) {

 	$roomtype = $_POST['RoomType'];
	$roomtypedescription = $_POST['RoomDescription'];
	$roomprice = $_POST['RoomPrice'];


	$query_Rtype_Save = "INSERT INTO roomtype (roomtype, roomtypedescription, roomprice) VALUES ('$roomtype','$roomtypedescription', '$roomprice')";
	$query_run_query_Rtype_Save = mysqli_query($db, $query_Rtype_Save);

	if ($query_run_query_Rtype_Save) {
		$_SESSION['RoomTypeMessage'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Room type added successfully!</h5>
		</div>
	
	';

 		echo "<script>window.location.href='../Admin/roomtype';</script>";

	} else {
		$_SESSION['RoomTypeMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Admin/roomtype';</script>";

	}

	mysqli_close($db);
}


if (isset($_POST['roomtypeedit'])) {
	$roomtypeid = $_POST['RoomTypeID'];
	$roomtype = $_POST['RoomType'];
	$roomtypedescription = $_POST['RoomDescription'];
	$roomprice = $_POST['RoomPrice'];


	$query_Rtype_Edit = "UPDATE roomtype SET roomtype='$roomtype', roomtypedescription='$roomtypedescription', roomprice='$roomprice' WHERE roomtypeid=$roomtypeid";
	$query_run_query_Rtype_Edit = mysqli_query($db, $query_Rtype_Edit);
	if ($query_run_query_Rtype_Edit) {
		$_SESSION['RoomTypeMessage'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Room type updated successfully!</h5>
		</div>
	
	';

	echo "<script>window.location.href='../Admin/roomtype';</script>";

	} else {
		$_SESSION['RoomTypeMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Admin/roomtype';</script>";

	}


	mysqli_close($db);
}

if (isset($_POST['roomtypedel'])) {
	$RoomID = $_POST['roomtype_id'];
	$query_Rtype_Delete = "DELETE FROM roomtype WHERE roomtypeid = $RoomID";
	$query_run_query_Rtype_Delete = mysqli_query($db, $query_Rtype_Delete);


	if ($query_run_query_Rtype_Delete) {
		$_SESSION['RoomTypeMessage'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Room type deleted successfully!</h5>
		</div>
	
	';

	echo "<script>window.location.href='../Admin/roomtype';</script>";

	} else {
		$_SESSION['RoomTypeMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Admin/roomtype';</script>";

	}

	mysqli_close($db);
}


//accommodation ----------------------------------------------------

if (isset($_POST['accommodationsave'])) {

 	$AccommodationType = $_POST['AccommodationType'];
	$AccommodationDescription = $_POST['AccommodationDescription'];

	$query_Accomm_Save = "INSERT INTO accommodation (accommodationtype, accommodationdescription) VALUES ('$AccommodationType','$AccommodationDescription')";
	$query_run_query_Accomm_Save = mysqli_query($db, $query_Accomm_Save);
	if ($query_run_query_Accomm_Save) {
		$_SESSION['AccommMessage'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Added successfully!</h5>
		</div>
	
	';

		 
		echo "<script>window.location.href='../Admin/accommodation';</script>";

	} else {
		$_SESSION['AccommMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Admin/accommodation';</script>";

	}

	mysqli_close($db);
}


if (isset($_POST['accommodationedit'])) {
	$AccommodationID = $_POST['AccommodationID'];
	$AccommodationType = $_POST['AccommodationType'];
	$AccommodationDescription = $_POST['AccommodationDescription'];


	$query_Accomm_Edit = "UPDATE accommodation SET accommodationtype='$AccommodationType', accommodationdescription='$AccommodationDescription' WHERE accommodationid=$AccommodationID";
	$query_run_query_Accomm_Edit = mysqli_query($db, $query_Accomm_Edit);

	if ($query_run_query_Accomm_Edit) {
		$_SESSION['AccommMessage'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Updated successfully!</h5>
		</div>
	
	';

	echo "<script>window.location.href='../Admin/accommodation';</script>";

	} else {
		$_SESSION['AccommMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Admin/accommodation';</script>";

	}

	mysqli_close($db);
}

if (isset($_GET['accommodationdel'])) {
	$AccommodationID = $_GET['accommodationdel'];
	$query_Accomm_Delete = "DELETE FROM accommodation WHERE accommodationid = $AccommodationID";
	$query_run_query_Accomm_Delete = mysqli_query($db, $query_Accomm_Delete);
	if ($query_run_query_Accomm_Delete) {
		$_SESSION['AccommMessage'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Deleted successfully!</h5>
		</div>
	
	';

	echo "<script>window.location.href='../Admin/accommodation';</script>";

	} else {
		$_SESSION['AccommMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Admin/accommodation';</script>";

	}
	mysqli_close($db);
}


//amenities--------------------------------------------------------------------------------------------------------
if (isset($_POST['AmenSave'])) {
	$AmenName = $_POST['AmenName'];
	$AmenRates = $_POST['AmenRates'];
	$AmenQuantity = $_POST['AmenQuantity'];

 
	$query_Amen_Save = "INSERT INTO amenities (AmenName, AmenRates, AmenQuantity) VALUES ('$AmenName', '$AmenRates', '$AmenQuantity' )";
	$query_run_query_Amen_Save = mysqli_query($db, $query_Amen_Save);

	if ($query_run_query_Amen_Save) {
 		$_SESSION['AmenMessage'] = '
			
				<div class="alert alert-success alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Added successfully!</h5>
				</div>
			
			';

		 
		echo "<script>window.location.href='../Admin/amenities';</script>";

	} else {
		$_SESSION['AmenMessage'] = '
				<div class="alert alert-danger alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Some error occured, please try again!</h5>
				</div>

			';

			echo "<script>window.location.href='../Admin/amenities';</script>";

	}
}


if (isset($_POST['AmenEdit'])) {
	$AmenID = $_POST['AmenID'];
	$AmenName = $_POST['AmenName'];
	$AmenRates = $_POST['AmenRates'];
	$AmenQuantity = $_POST['AmenQuantity'];


	$query_Amen_Edit = "UPDATE amenities SET AmenName='$AmenName', AmenRates='$AmenRates', AmenQuantity='$AmenQuantity' WHERE AmenID=$AmenID";
	$query_run_query_Amen_Edit = mysqli_query($db, $query_Amen_Edit);

	if ($query_run_query_Amen_Edit) {
 		$_SESSION['AmenMessage'] = '
			
				<div class="alert alert-success alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Updated successfully!</h5>
				</div>
			
			';
			echo "<script>window.location.href='../Admin/amenities';</script>";

	} else {
		$_SESSION['AmenMessage'] = '
				<div class="alert alert-danger alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Some error occured, please try again!</h5>
				</div>

			';

			echo "<script>window.location.href='../Admin/amenities';</script>";

	}
}

if (isset($_POST['AmenDelete'])) {
	$AmenID = $_POST['AmenID'];
	$query_Amen_Delete = "DELETE FROM amenities WHERE AmenID=$AmenID";
	$query_run_query_Amen_Delete = mysqli_query($db, $query_Amen_Delete);

	if ($query_run_query_Amen_Delete) {
		$_SESSION['AmenMessage'] = '
			
		<div class="alert alert-success alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Deleted successfully!</h5>
		</div>
	
	';

	echo "<script>window.location.href='../Admin/amenities';</script>";

	} else {
		$_SESSION['AmenMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Admin/amenities';</script>";

	}

	mysqli_close($db);
}


					
//new bookbtn---------------------------------------------------------------
if (isset($_POST['BookButton'])) {
	$GuestID = $_POST['GuestID'];

	$RoomID = $_POST['RoomID'];

	$GuestNumber = $_POST['GuestNumber'];
	$GuestNumber2 = $_POST['GuestNumber2'];

	$Name = $_POST['Name'];
	$Nationality = $_POST['Nationality'];
	$Birthdate = $_POST['Birthdate'];
	$PNumber = $_POST['PNumber'];
	$Email = $_POST['Email'];
	$Address = $_POST['Address'];
	$Company = $_POST['Company'];
	$CompanyAddress = $_POST['CompanyAddress'];
	$Origin = $_POST['Origin'];
	$Passport = $_POST['Passport'];
	$IssuedAt = $_POST['IssuedAt'];
	$Discount = $_POST['Discount'];

	$TransactionDate = $_POST['TransactionDate'];
	$TransactionTime = $_POST['TransactionTime'];
	$TransactionCode = $_POST['TransactionCode'];
	$TransactBy = $_POST['TransactBy'];

	$Arrival = $_POST['Arrival'];
	$Departure = $_POST['Departure'];
	$TotalRates = $_POST['TotalRates'];

	$insertArrival = date("Y-m-d",strtotime($Arrival));
	$insertDeparture = date("Y-m-d",strtotime($Departure));

	
	if($GuestID != ''){
		$query_guest_update = "UPDATE guest SET GuestNumber='$GuestNumber', GuestNumber2='$GuestNumber2', Discount='$Discount', RoomID = $RoomID, TransactionCode = '$TransactionCode'
			WHERE GuestID = '$GuestID'";
		$run_query_guest_update = mysqli_query($db, $query_guest_update);

		$sql_transfer_to_recent_guest = "INSERT INTO recent_guest (GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode)		
			SELECT 
			GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode		 	FROM guest WHERE GuestID = '$GuestID'";
		$run_sql_transfer_to_recent_guest = mysqli_query($db, $sql_transfer_to_recent_guest);	

	}else{
		$query_guest_save = "INSERT INTO guest (GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode) 
		VALUES ('$GuestNumber', '$GuestNumber2', '$Name', '$Nationality', '$Birthdate', '$PNumber',  '$Email', '$Address', '$Company', '$CompanyAddress', '$Origin', '$Passport', '$IssuedAt', '$Discount', '$RoomID', 
		'$TransactionCode')";
		$run_query_guest_save = mysqli_query($db, $query_guest_save);

		$sql_transfer_to_recent_guest = "INSERT INTO recent_guest (
		GuestNUmber, GuestNUmber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode)		
		SELECT 
		GuestNUmber, GuestNUmber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode
		FROM guest WHERE TransactionCode = '$TransactionCode'";
		$run_sql_transfer_to_recent_guest = mysqli_query($db, $sql_transfer_to_recent_guest);

		
	}

	$query_select_Guest = "SELECT * FROM guest WHERE RoomID = $RoomID";
	$run_query_select_Guest = mysqli_query($db, $query_select_Guest);
	$row = mysqli_fetch_assoc($run_query_select_Guest);
	$GID = $row['GuestID'];
	

	 
		$query_trans_save = "INSERT INTO transaction (TransactionDate, TransactionTime, TransactionCode, TransactBy, GuestID,  RoomID, Arrival, Departure, TotalRates) 
		VALUES ('$TransactionDate', '$TransactionTime', '$TransactionCode', '$TransactBy', '$GID', '$RoomID', '$insertArrival', '$insertDeparture', '$TotalRates')";
		$run_query_trans_save = mysqli_query($db, $query_trans_save);

		
		$query2 = "UPDATE rooms SET RoomStatus='Booked' WHERE RoomID = $RoomID";
		$query_run2 = mysqli_query($db, $query2);

		$query_update_guest_to_blank = "UPDATE guest SET TransactionCode='', RoomID ='0' WHERE RoomID = $RoomID";
		$query_query_update_guest_to_blank = mysqli_query($db, $query_update_guest_to_blank);

		if ($run_query_trans_save && $query_run2) {
			$_SESSION['BookingMessage'] = '
						
						<div class="alert alert-success alert-dismissable" id="flash-msg">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<h5>Guest has been booked successfully</h5>
						</div>
				
				';
				mysqli_close($db);

 			echo "<script>window.location.href='../Staff/booking';</script>";

		} else {
			$_SESSION['BookingMessage'] = '
					<div class="alert alert-danger alert-dismissable" id="flash-msg">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<h5>Some error occured, please try again!</h5>
					</div>
			
				';

				
				mysqli_close($db);

				echo "<script>window.location.href='../Staff/booking';</script>";

		}

		mysqli_close($db);

	 
	
}


//cancel btn booking payment settlement------------------------------
if (isset($_POST['CancelBtn'])) {
	$tcodee = $_POST['transactionCode'];
	$query_cancel_booking = "DELETE FROM amen_transaction WHERE TransactionCode='$tcodee'";
	$query_run_query_cancel_booking = mysqli_query($db, $query_cancel_booking);

	mysqli_close($db);

 	echo "<script>window.location.href='../Staff/booking';</script>";

}

//reservation bookbtn---------------------------------------------------------------
if (isset($_POST['Reserve_BookButton'])) {
	$GuestID = $_POST['GuestID'];

	$RoomID = $_POST['RoomID'];

	$GuestNumber = $_POST['GuestNumber'];
	$GuestNumber2 = $_POST['GuestNumber2'];

	$Name = $_POST['Name'];
	$Nationality = $_POST['Nationality'];
	$Birthdate = $_POST['Birthdate'];
	$PNumber = $_POST['PNumber'];
	$Email = $_POST['Email'];
	$Address = $_POST['Address'];
	$Company = $_POST['Company'];
	$CompanyAddress = $_POST['CompanyAddress'];
	$Origin = $_POST['Origin'];
	$Passport = $_POST['Passport'];
	$IssuedAt = $_POST['IssuedAt'];
	$Discount = $_POST['Discount'];

	$Requests = $_POST['Requests'];
	$Downpayment = $_POST['Downpayment'];
	$Accommodation = $_POST['Accommodation'];

	$TransactionDate = $_POST['TransactionDate'];
	$TransactionTime = $_POST['TransactionTime'];
	$TransactionCode = $_POST['TransactionCode'];
	$TransactBy = $_POST['TransactBy'];

	$Arrival = $_POST['Arrival'];
	$Departure = $_POST['Departure'];
	$TotalRates = $_POST['TotalRates'];

	$insertArrival = date("Y-m-d",strtotime($Arrival));
	$insertDeparture = date("Y-m-d",strtotime($Departure));

	$query_guest = "UPDATE guest SET  Name = '$Name',
		Nationality = '$Nationality', Birthdate = '$Birthdate', PNumber = '$PNumber', 
		Email = '$Email',  Address = '$Address', Company = '$Company', CompanyAddress = '$CompanyAddress',
		Origin = '$Origin', Passport = '$Passport', IssuedAt = '$IssuedAt'
		WHERE GuestID = '$GuestID'";
		$run_query_guest = mysqli_query($db, $query_guest);

	$query_recent_guest = "UPDATE recent_guest SET GuestNumber = '$GuestNumber', GuestNumber2 = '$GuestNumber2', Name = '$Name',
		Nationality = '$Nationality', Birthdate = '$Birthdate', PNumber = '$PNumber', 
		Email = '$Email',  Address = '$Address', Company = '$Company', CompanyAddress = '$CompanyAddress',
		Origin = '$Origin', Passport = '$Passport', IssuedAt = '$IssuedAt', Discount = '$Discount'
		WHERE TransactionCode = '$TransactionCode'";
	$run_query_recent_guest = mysqli_query($db, $query_recent_guest);

	$query_trans_reserve = "INSERT INTO transaction (TransactionDate, TransactionTime, TransactionCode, TransactBy, GuestID,  RoomID, Accommodationtype, Arrival, Departure, TotalRates, Downpayment, Requests) 
		VALUES ('$TransactionDate', '$TransactionTime', '$TransactionCode', '$TransactBy', '$GuestID', '$RoomID', '$Accommodation', '$insertArrival', '$insertDeparture', '$TotalRates', '$Downpayment', '$Requests')";
	$run_query_trans_reserve = mysqli_query($db, $query_trans_reserve);

	$query_del_reserve = "UPDATE reservation SET ReservationStatus = 'CheckIn' WHERE TransactionCode='$TransactionCode'";
	$run_query_del_reserve = mysqli_query($db, $query_del_reserve);

	$query_book_room = "UPDATE rooms SET RoomStatus = 'Booked' WHERE RoomID='$RoomID'";
	$run_query_book_room = mysqli_query($db, $query_book_room);

	if ($run_query_guest && $run_query_recent_guest && $run_query_trans_reserve && $run_query_del_reserve && $run_query_book_room) {
		$_SESSION['BookingMessage'] = '
					
					<div class="alert alert-success alert-dismissable" id="flash-msg">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<h5>Guest has been booked successfully</h5>
					</div>
			
			';
			mysqli_close($db);

			echo "<script>window.location.href='../Staff/booking';</script>";

	} else {
		$_SESSION['BookingMessage'] = '
				<div class="alert alert-danger alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Some error occured, please try again!</h5>
				</div>
		
			';

			
			mysqli_close($db);

			echo "<script>window.location.href='../Staff/booking';</script>";

	}


}

//cancel btn reservation payment settlement------------------------------
if (isset($_POST['CancelBtnReserve'])) {
	//$tcodee = $_POST['transactionCode'];
	//$query_cancel_reservation = "DELETE FROM amen_transaction WHERE TransactionCode='$tcodee'";
	//$query_run_query_cancel_reservation = mysqli_query($db, $query_cancel_reservation);

	//mysqli_close($db);

 	echo "<script>window.location.href='../Staff/reservation';</script>";

}


//transferring data to recent transactions because of checkout
if (isset($_POST['tID'])) {
	$transaction_ID = $_POST['transactionID'];

	$sql = "SELECT * FROM transaction WHERE TransactionCode = $transaction_ID";
	$result = mysqli_query($db, $sql);
	$row  = mysqli_fetch_assoc($result);

	$GuestID = $row['GuestID'];
	$RoomID = $row['RoomID'];
	$RoomStatus = "Vacant";

	$queryupdate = "UPDATE rooms SET RoomStatus='$RoomStatus' WHERE RoomID = $RoomID";
	$query_update = mysqli_query($db, $queryupdate);

	$queryupdate_res = "UPDATE reservation SET RoomID='', ReservationStatus='CheckOut' WHERE TransactionCode = $transaction_ID";
	$query_update_res = mysqli_query($db, $queryupdate_res);

	$sql_transfer = "INSERT INTO recent_transaction SELECT * FROM transaction WHERE TransactionCode = $transaction_ID";
	$run_transfer = mysqli_query($db, $sql_transfer);


	$querydelete = "DELETE FROM transaction WHERE TransactionCode = $transaction_ID";
	$run = mysqli_query($db, $querydelete);

	if ($query_update && $run_transfer && $run) {
		$_SESSION['BookingMessage'] = '
				
				<div class="alert alert-info alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Guest has been checked out</h5>
				</div>
		
		';

 		echo "<script>window.location.href='../Staff/booking';</script>";

	} else {
		$_SESSION['BookingMessage'] = '
			<div class="alert alert-danger alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Some error occured, please try again!</h5>
			</div>
	
		';

		echo "<script>window.location.href='../Staff/booking';</script>";
	}


	mysqli_close($db);
}

if (isset($_GET['RID'])) {
	$room_ID = $_GET['RID'];

	$RoomStatus = "Booked";
	$queryupdate_Room = "UPDATE rooms SET RoomStatus='$RoomStatus' WHERE RoomID = $room_ID";
	$run_queryupdate_Room = mysqli_query($db, $queryupdate_Room);

	mysqli_close($db);
 	echo "<script>window.location.href='../Staff/booking';</script>";

}

//staff is the one reserving the guest---------------------------------------------------------------
if (isset($_POST['ReserveButton'])) {
	$RRoomID = $_POST['RRoomID'];

	$GuestIDReserve = $_POST['GuestID'];

	$GuestNumber = $_POST['GuestNumber'];
	$GuestNumber2 = $_POST['GuestNumber2'];
	$Requests = $_POST['Guest_Request'];

	$Name = $_POST['Name'];
	$Nationality = $_POST['Nationality'];
	$Birthdate = $_POST['Birthdate'];
	$PNumber = $_POST['PNumber'];
	$Email = $_POST['Email'];
	$Address = $_POST['Address'];
	$Company = $_POST['Company'];
	$CompanyAddress = $_POST['CompanyAddress'];
	$Origin = $_POST['Origin'];
	$Passport = $_POST['Passport'];
	$IssuedAt = $_POST['IssuedAt'];

	$datenow = date('Ymd');
	$timenow = date("His");
	$TransactionCode = $datenow . '' . $timenow;

	$TransactionDate = date("Y/m/d");
	$TransactionTime = date("h:i a");

	$TransactBy = $_POST['TransactBy'];
	$Accommodation = $_POST['RAccommodation'];
	$ArrivalR = $_POST['RArrival'];
	$DepartureR = $_POST['RDeparture'];
	$totalRates = $_POST['totalRates'];

	$ReserveStatus = "Pending";

	if(!empty($GuestIDReserve)){
		$query_guest_update = "UPDATE guest SET GuestNumber='$GuestNumber', GuestNumber2='$GuestNumber2', RoomID = $RRoomID, TransactionCode = '$TransactionCode'
			WHERE GuestID = '$GuestIDReserve'";
		$run_query_guest_update = mysqli_query($db, $query_guest_update);

		$sql_transfer_to_recent_guest = "INSERT INTO recent_guest (GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode)		
			SELECT 
			GuestNUmber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode		 	FROM guest WHERE GuestID = '$GuestIDReserve'";
		$run_sql_transfer_to_recent_guest = mysqli_query($db, $sql_transfer_to_recent_guest);	

	}else{
		$query_guest_save = "INSERT INTO guest (GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, RoomID, TransactionCode) 
		VALUES ('$GuestNumber', '$GuestNumber2', '$Name', '$Nationality', '$Birthdate', '$PNumber',  '$Email', '$Address', '$Company', '$CompanyAddress', '$Origin', '$Passport', '$IssuedAt', '$RRoomID', 
		'$TransactionCode')";
		$run_query_guest_save = mysqli_query($db, $query_guest_save);

		$sql_transfer_to_recent_guest = "INSERT INTO recent_guest (
		GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode)		
		SELECT 
		GuestNUmber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt, Discount, RoomID, TransactionCode
		FROM guest WHERE TransactionCode = '$TransactionCode'";
		$run_sql_transfer_to_recent_guest = mysqli_query($db, $sql_transfer_to_recent_guest);

		
	}

	



	$query_select_Guest = "SELECT * FROM guest WHERE RoomID = $RRoomID";
	$run_query_select_Guest = mysqli_query($db, $query_select_Guest);
	$row = mysqli_fetch_assoc($run_query_select_Guest);
	$GID = $row['GuestID'];


	$query_trans_save = "INSERT INTO reservation (TransactionDate, TransactionTime, TransactionCode, TransactBy, GuestID,  RoomID, Accommodationtype, Arrival, Departure, TotalRates, Downpayment, ReservationStatus, Requests) 
	VALUES ('$TransactionDate','$TransactionTime','$TransactionCode', '$TransactBy', '$GID',  '$RRoomID', '$Accommodation', '$ArrivalR', '$DepartureR', '$totalRates', 0, 'Approved', '$Requests')";
	$run_query_trans_save = mysqli_query($db, $query_trans_save);

	
	$query_update_guest_to_blank = "UPDATE guest SET TransactionCode='', RoomID ='0' WHERE RoomID = $RRoomID";
	$query_query_update_guest_to_blank = mysqli_query($db, $query_update_guest_to_blank);

	if ($run_sql_transfer_to_recent_guest && $run_sql_transfer_to_recent_guest && $run_query_trans_save && $query_query_update_guest_to_blank) {
		$_SESSION['StaffReservationConfirmMessage'] = '
		
		<div class="alert alert-info alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Guest reserved successfully</h5>
		</div>

';
mysqli_close($db);

 		echo "<script>window.location.href='../Staff/reservation';</script>";

	} else {
		$_SESSION['BookingMessage'] = '
			<div class="alert alert-danger alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Some error occured, please try again!</h5>
			</div>		
		';

		mysqli_close($db);
		echo "<script>window.location.href='../Staff/reservation';</script>";
	}

	mysqli_close($db);

}



//Customer sign up ---------------------------------------------------------------------------------------------
if (isset($_POST['CustomerSave'])) {

	$Name = $_POST['Name'];

	$PNumber = $_POST['PNumber'];
	$Email = $_POST['Email'];

	$Username = $_POST['Username'];
	$Password = $_POST['Password'];
	$Password = md5($Password);

	$query_Customer_Signup =  "INSERT INTO web_user (wName, wPNumber, wEmail, wUName, wPWord) 
						VALUES ('$Name', '$PNumber', '$Email', '$Username', '$Password')";
	$query_run_query_Customer_Signup = mysqli_query($db, $query_Customer_Signup);

	if ($query_run_query_Customer_Signup) {
		$_SESSION['SignUpMessage'] = '
			
			<div class="alert alert-success alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Account Created Successfully!</h5>
			</div>
	
	';

	echo "<script>window.location.href='../signup';</script>";

 	} else {
		$_SESSION['SignUpMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../signup';</script>";
	}
	mysqli_close($db);
}

//customer reservation-----------------------------------------------------------------
if (isset($_POST['btnReserve'])) {

	$RRoomID = $_POST['RRoomID'];
	$wID = $_POST['RGuestID'];

	$GuestNumber = $_POST['GuestNumber'];
	$Name = $_POST['Name'];
	$Nationality = $_POST['Nationality'];
	$Birthdate = $_POST['Birthdate'];
	$PNumber = $_POST['PNumber'];
	$Email = $_POST['Email'];
	$Address = $_POST['Address'];
	$Company = $_POST['Company'];
	$CompanyAddress = $_POST['CompanyAddress'];
	$Origin = $_POST['Origin'];
	$Passport = $_POST['Passport'];
	$IssuedAt = $_POST['IssuedAt'];

	$datenow = date('Ymd');
	$timenow = date("His");
	$RTransactionCode = $datenow . '' . $timenow;

	$RTransactionDate = date("Y/m/d");
	$RTransactionTime = date("h:i a");

	$RAccommodation = $_POST['RAccommodation'];
	$RArrivalR = $_POST['RArrival'];
	$RDepartureR = $_POST['RDeparture'];
	$totalRates = $_POST['totalRates'];

	$ReserveStatus = "Pending";

	$query_guest_save = "INSERT INTO guest (GuestNumber, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt,  RoomID, TransactionCode, wID) 
		VALUES ('$GuestNumber', '$Name', '$Nationality', '$Birthdate', '$PNumber',  '$Email', '$Address', '$Company', '$CompanyAddress', '$Origin', '$Passport', '$IssuedAt', '$RRoomID', 
		'$RTransactionCode', '$wID')";
	$run_query_guest_save = mysqli_query($db, $query_guest_save);


	$query_1 = "SELECT * FROM guest WHERE wID = $wID";
	$query_run1 = mysqli_query($db, $query_1);
	$res = mysqli_fetch_assoc($query_run1);

	$GTransactionCode = $res['TransactionCode'];
	$RGuestID = $res['GuestID'];

	$insertArrival = date("Y-m-d",strtotime($RArrivalR));
	$insertDeparture = date("Y-m-d",strtotime($RDepartureR));

	$query_reservation_transaction = "INSERT INTO reservation (TransactionDate, TransactionTime, TransactionCode, GuestID, RoomID, Accommodationtype, Arrival, Departure, TotalRates, ReservationStatus) 
	VALUES ('$RTransactionDate','$RTransactionTime','$GTransactionCode', '$RGuestID', '$RRoomID', '$RAccommodation', '$insertArrival', '$insertDeparture', '$totalRates', '$ReserveStatus')";
	$run_query_reservation_transaction = mysqli_query($db, $query_reservation_transaction);


	$sql_transfer_to_recent_guest = "INSERT INTO recent_guest (
		GuestNumber, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt,  RoomID, TransactionCode, wID)		
		SELECT 
		GuestNumber, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt,  RoomID, TransactionCode, wID
		FROM guest WHERE TransactionCode='$GTransactionCode'";
		
	$run_sql_transfer_to_recent_guest = mysqli_query($db, $sql_transfer_to_recent_guest);

	$query_Reset_Guest = "UPDATE guest SET RoomID = '0', TransactionCode='', wID = '0' WHERE wID = $wID";
	$run_query_Reset_Guest = mysqli_query($db, $query_Reset_Guest);


	if ($run_query_guest_save && $run_query_reservation_transaction && $run_sql_transfer_to_recent_guest && $run_query_Reset_Guest) {
		$_SESSION['TransReservationMessage'] = '
			
			<div class="alert alert-success alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Room reservation request sent successfully!</h5>
			</div>
	
	';

 		echo "<script>window.location.href='../transaction';</script>";

	} else {
		$_SESSION['ReservationMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

 		echo "<script>window.location.href='..';</script>";

	}


	mysqli_close($db);
}


//customer delete denied reservation-------------------------------------
if (isset($_GET['deleteReservation'])) {
	$tcode = $_GET['deleteReservation'];

	
	$query_denied_del_recent_guest = "DELETE FROM recent_guest WHERE TransactionCode = $tcode";
	$run_query_denied_del_recent_guest = mysqli_query($db, $query_denied_del_recent_guest);

	$query_denied_del = "DELETE FROM reservation WHERE TransactionCode = $tcode";
	$run_query_denied_del = mysqli_query($db, $query_denied_del);
	
	if ( $run_query_denied_del_recent_guest && $run_query_denied_del) {
		$_SESSION['TransReservationMessage'] = '
			
			<div class="alert alert-warning alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Reservation deleted successfully!</h5>
			</div>
	
	';
	mysqli_close($db);
	echo "<script>window.location.href='../transaction';</script>";

 	} else {
		$_SESSION['TransReservationMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';
	mysqli_close($db);
 	echo "<script>window.location.href='../transaction';</script>";

	}

}


//customer cancels reservation-------------------------------------
if (isset($_POST['cancelReservation'])) {
	$tcode = $_POST['transactionID'];

	$query_select_reservation = "SELECT * FROM reservation WHERE TransactionCode = $tcode";
	$run_query_select_reservation = mysqli_query($db, $query_select_reservation);
	$row = mysqli_fetch_assoc($run_query_select_reservation);
	$GGid = $row['GuestID'];


	$query_cancel_reservation = "DELETE FROM reservation WHERE TransactionCode = $tcode";
	$run_query_cancel_reservation = mysqli_query($db, $query_cancel_reservation);

	$query_cancel = "DELETE FROM recent_guest WHERE TransactionCode = $tcode";
	$run_query_cancel = mysqli_query($db, $query_cancel);
	
	if ($run_query_cancel_reservation && $run_query_cancel) {
		$_SESSION['TransReservationMessage'] = '
			
			<div class="alert alert-warning alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Reservation has been cancelled!</h5>
			</div>
	
	';
	mysqli_close($db);
 	echo "<script>window.location.href='../transaction';</script>";

	} else {
		$_SESSION['TransReservationMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';
	mysqli_close($db);
 	echo "<script>window.location.href='../transaction';</script>";

	}

}

//customer delete out reservation-------------------------------------
if (isset($_POST['cancelReservation_out'])) {
	$tcode = $_POST['transactionID'];

	$query_select_reservation = "SELECT * FROM reservation WHERE TransactionCode = $tcode";
	$run_query_select_reservation = mysqli_query($db, $query_select_reservation);
	$row = mysqli_fetch_assoc($run_query_select_reservation);
	$GGid = $row['GuestID'];


	$query_cancel_reservation = "DELETE FROM reservation WHERE TransactionCode = $tcode";
	$run_query_cancel_reservation = mysqli_query($db, $query_cancel_reservation);

	$query_cancel = "DELETE FROM recent_guest WHERE TransactionCode = $tcode";
	$run_query_cancel = mysqli_query($db, $query_cancel);
	
	if ($run_query_cancel_reservation && $run_query_cancel) {
		$_SESSION['TransReservationMessage'] = '
			
			<div class="alert alert-warning alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Transaction has been deleted!</h5>
			</div>
	
	';
	mysqli_close($db);
 	echo "<script>window.location.href='../transaction';</script>";

	} else {
		$_SESSION['TransReservationMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';
	mysqli_close($db);
 	echo "<script>window.location.href='../transaction';</script>";

	}

}


// staf COnfirmed Reservation to Booking check in------------------------------------------------------
if (isset($_POST['confirm_reservation_roomid'])) {

	$TransactByy = $_SESSION['staffname'];
	$Trans_Code = $_POST['transactionCode'];

	$query_Select_reservation = "SELECT * FROM reservation WHERE TransactionCode = $Trans_Code";
	$query_Run_query_Select_reservation = mysqli_query($db, $query_Select_reservation);
	$resss = mysqli_fetch_assoc($query_Run_query_Select_reservation);

	$R_RRoomID = $resss['RoomID'];

	$query_check_room_status = "SELECT * FROM rooms WHERE RoomID = $R_RRoomID";
	$run_query_check_room_status = mysqli_query($db, $query_check_room_status);
	$result_query_check_room_status = mysqli_fetch_assoc($run_query_check_room_status);
	$Room_statuss = $result_query_check_room_status['RoomStatus'];

	if ($Room_statuss == "Vacant") {




		$queryReserve = "INSERT INTO transaction ( TransactionDate,	
		TransactionTime,	TransactionCode,	TransactBy,	GuestID, RoomID,	Accommodationtype,	Arrival,
		Departure,	TotalRates) SELECT TransactionDate,	
		TransactionTime,	TransactionCode,	TransactBy,	GuestID, RoomID,	Accommodationtype,	Arrival,
		Departure,	TotalRates	 FROM reservation WHERE TransactionCode = $Trans_Code";
		$run_queryResere = mysqli_query($db, $queryReserve);

		$query_RRguest = "UPDATE transaction SET RoomID = '$R_RRoomID', Accommodationtype = 'Reservation', TransactBy = '$TransactByy' WHERE TransactionCode = $Trans_Code";
		$query_Run_RRguest = mysqli_query($db, $query_RRguest);

		$query_RRRoom = "UPDATE rooms SET RoomStatus = 'Booked' WHERE RoomID = $R_RRoomID";
		$query_Run_RRRoomt = mysqli_query($db, $query_RRRoom);

		$query_delete_reserve = "DELETE  FROM reservation WHERE TransactionCode = $Trans_Code";
		$run_query_delete_reserve = mysqli_query($db, $query_delete_reserve);


		if ($run_queryResere && $query_Run_RRguest &&  $query_Run_RRRoomt && $run_query_delete_reserve) {
			$_SESSION['StaffReservationConfirmMessage'] = '
			
			<div class="alert alert-success alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Reservation has been booked successfully!</h5>
			</div>
	
	';

 			echo "<script>window.location.href='../Staff/reservation';</script>";

		} else {
			$_SESSION['StaffReservationConfirmMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Staff/reservation';</script>";
}
	} else {
		$_SESSION['StaffReservationConfirmMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h4>The room was occupied, you need to check them out first!</h4>
		</div>

	';

	echo "<script>window.location.href='../Staff/reservation';</script>";
}

	mysqli_close($db);
}

//staff View reservation --- wala pa di tapos
if (isset($_GET['view_reservation_roomid'])) {

	$Trans_Code = $_GET['view_reservation_roomid'];


	mysqli_close($db);
	echo "<script>window.location.href='../Staff/reservation';</script>";
}

//staff approve online requeest for reservation

if (isset($_POST['approvebtn'])) {
	$t_code = $_POST['transactionCode'];

	$query_reser = "UPDATE reservation SET ReservationStatus = 'Approved' WHERE TransactionCode = $t_code";
	$query_query_reser = mysqli_query($db, $query_reser);

	if ($query_query_reser) {
		$_SESSION['StaffReservationConfirmMessage'] = '
			
			<div class="alert alert-info alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Reservation Confirmed</h5>
			</div>
	
	';

	echo "<script>window.location.href='../Staff/reservation';</script>";
} else {
		$_SESSION['StaffReservationConfirmMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Staff/reservation';</script>";
}

	mysqli_close($db);
}

//staff decline online requeest for reservation
if (isset($_POST['declinebtn'])) {
	$t_code = $_POST['transactionCode'];

	$query_reser_del = "UPDATE reservation SET ReservationStatus = 'Denied'  WHERE TransactionCode = $t_code";
	$query_reser_del = mysqli_query($db, $query_reser_del);

	//$query_reser_del = "DELETE FROM recent_guest WHERE TransactionCode = $t_code";
	//$query_reser_del = mysqli_query($db, $query_reser_del);

	

	if ($query_reser_del) {
		$_SESSION['StaffReservationConfirmMessage'] = '
			
			<div class="alert alert-warning alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Reservation declined </h5>
			</div>
	
	';

	echo "<script>window.location.href='../Staff/reservation';</script>";
} else {
		$_SESSION['StaffReservationConfirmMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Staff/reservation';</script>";
}

	mysqli_close($db);
}


//staff cancels approve reservation---------------------------------------------------------------
if (isset($_POST['cancelreservebtn'])) {
	$t_code = $_POST['transactionCode'];

	$query_reser_SELECT = "SELECT * FROM reservation  WHERE TransactionCode = $t_code";
	$run_query_reser_SELECT = mysqli_query($db, $query_reser_SELECT);
	$row = mysqli_fetch_assoc($run_query_reser_SELECT);

	$Gid = $row['GuestID'];

	if($row['Accommodationtype'] == 'Online Reservation'){
		$query_reser_del1 = "UPDATE reservation SET ReservationStatus = 'Denied'  WHERE TransactionCode = $t_code";
		$run_query_reser_del1 = mysqli_query($db, $query_reser_del1);

		//$query_guest_del = "DELETE FROM guest WHERE GuestID = $Gid";
		//$run_query_guest_del = mysqli_query($db, $query_guest_del);

	

		if ($run_query_reser_del1) {
			$_SESSION['StaffReservationConfirmMessage'] = '
				
				<div class="alert alert-warning alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Reservation has been cancelled </h5>
				</div>
		
		';
			mysqli_close($db);
			echo "<script>window.location.href='../Staff/reservation';</script>";
		} else {
			$_SESSION['StaffReservationConfirmMessage'] = '
			<div class="alert alert-danger alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Some error occured, please try again!</h5>
			</div>
	
		';
			mysqli_close($db);
			echo "<script>window.location.href='../Staff/reservation';</script>";
		}
	}elseif($row['Accommodationtype'] == 'Reservation'){
		$query_reser_del1 = "DELETE FROM reservation WHERE TransactionCode = $t_code";
		$run_query_reser_del1 = mysqli_query($db, $query_reser_del1);
	
		$query_reser_del2 = "DELETE FROM recent_guest WHERE TransactionCode = $t_code";
		$run_query_reser_del2 = mysqli_query($db, $query_reser_del2);

		

		if ($run_query_reser_del1 && $run_query_reser_del2) {
			$_SESSION['StaffReservationConfirmMessage'] = '
				
				<div class="alert alert-warning alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Reservation has been cancelled </h5>
				</div>
		
		';
			mysqli_close($db);
			echo "<script>window.location.href='../Staff/reservation';</script>";
		} else {
			$_SESSION['StaffReservationConfirmMessage'] = '
			<div class="alert alert-danger alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Some error occured, please try again!</h5>
			</div>
	
		';
			mysqli_close($db);
			echo "<script>window.location.href='../Staff/reservation';</script>";
		}
	}
	

	

	

}

//staff cancelation of booking ------- to be deleted------------
if (isset($_GET['cancelBookingbtn'])) {
	$t_code = $_GET['cancelBookingbtn'];

	$query_selection = "SELECT * FROM transaction WHERE TransactionCode = $t_code";
	$query_query_selection = mysqli_query($db, $query_selection);
	$ressss = mysqli_fetch_assoc($query_query_selection);
	$rrrid = $ressss['RoomID'];

	$RoomStatus = "Vacant";
	$queryupdateRoom = "UPDATE rooms SET RoomStatus='$RoomStatus' WHERE RoomID = $rrrid";
	$run_query_update = mysqli_query($db, $queryupdateRoom);

	$query_reser_del = "DELETE FROM transaction WHERE TransactionCode = $t_code";
	$query_reser_del = mysqli_query($db, $query_reser_del);

	$query_guest_del = "DELETE FROM recent_guest WHERE TransactionCode = $t_code";
	$query_guest_del = mysqli_query($db, $query_guest_del);

	if ($run_query_update && $query_reser_del && $query_guest_del) {
		$_SESSION['BookingMessage'] = '
			
			<div class="alert alert-warning alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Booking has been Cancelled</h5>
			</div>
	
	';

 		echo "<script>window.location.href='../Staff/booking';</script>";

	} else {
		$_SESSION['BookingMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

	echo "<script>window.location.href='../Staff/booking';</script>";
}

	mysqli_close($db);
}


$TransactionCode = '';
if(isset($_POST['update_booking_btn'])){

    $TransactionCode = $_POST['TransactionCode'];
    $sql_query = "SELECT * FROM transaction WHERE TransactionCode = $TransactionCode";
    $run_sql_query = mysqli_query($db, $sql_query);
    $out = mysqli_fetch_assoc($run_sql_query);

    $Guest_ID = $out['GuestID'];
     
    $GuestNumber = $_POST['GuestNumber'];
	$GuestNumber2 = $_POST['GuestNumber2'];

    $Name = $_POST['Name'];
    $Nationality = $_POST['Nationality'];
    $Birthdate = $_POST['Birthdate'];
    $PNumber = $_POST['PNumber'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $Company = $_POST['Company'];
    $CompanyAddress = $_POST['CompanyAddress'];
    $Origin = $_POST['Origin'];
    $Passport = $_POST['Passport'];
    $IssuedAt = $_POST['IssuedAt'];
    $Discount = $_POST['Discount'];

	$price = $_POST['RoomPrice'];

    $Arrival = $_POST['Arrival'];
    $Departure = $_POST['Departure'];

 
		//-------------------------------------------------------------------------------------------------------------------------

		
		
		//update amenities
		$amen_Qty = array();
		  $amen = $_POST['amenities'];
		 foreach($amen as $value){
			 $amen_Qty[] = $value;
		}
		  
		
		$aRates = array();
		$amen_ID = array();
		$amen_Name = array();
	
	
		//existing record
		$sql_amen = "SELECT * FROM amen_transaction WHERE TransactionCode = $TransactionCode";
		 $run_sql_amen = mysqli_query($db, $sql_amen);
		 if(mysqli_num_rows($run_sql_amen) > 0){
			while($row_amen = mysqli_fetch_array($run_sql_amen)){
				$aID = $row_amen['AmenID'];
				$aName = $row_amen['AmenName'];
				$aRates = $row_amen['AmenRates'];
	
				$amen_ID[] = $aID;
				$amen_Name[] = $aName;
				$amen_Rates[] = $aRates;
			}
		}
		
		//no record
		$sql_amen2 = "SELECT * FROM amenities WHERE AmenID NOT IN(SELECT AmenID FROM amen_transaction WHERE TransactionCode = $TransactionCode)";
		$run_sql_amen2 = mysqli_query($db, $sql_amen2);
		if(mysqli_num_rows($run_sql_amen2) > 0){
			while($row_amen2 = mysqli_fetch_array($run_sql_amen2)){
			$aID2 = $row_amen2['AmenID'];
			$aName2 = $row_amen2['AmenName'];
			$aRates2 = $row_amen2['AmenRates'];
	
			$amen_ID[] = $aID2;
			$amen_Name[] = $aName2;
			$amen_Rates[] = $aRates2;
			}
		}

		//buggy shit
		$query_delete = "SELECT * FROM amen_transaction WHERE  TransactionCode = '$TransactionCode'";
		$run_query_delete = mysqli_query($db, $query_delete);
		if(mysqli_num_rows($run_query_delete)>0){
			while($del_rows = mysqli_fetch_array($run_query_delete)){
				$idd = $del_rows['id'];
				$segre_del = "DELETE FROM amen_transaction WHERE id = '$idd'";
				$run_segre_del = mysqli_query($db, $segre_del);
			}
		}
	
		//$delete_past = "DELETE * FROM amen_transaction WHERE TransactionCode = '$TransactionCode'";
		//$run_delete = mysqli_query($db, $delete_past);
	
		
		for($i = 0; $i < count($amen_Qty); $i++){
			$amount = (double)$amen_Rates[$i] * (double)$amen_Qty[$i];
			 
			$query_save = "INSERT INTO amen_transaction (TransactionCode, AmenID, AmenName, AmenQuantity, AmenRates) VALUES 
			('$TransactionCode', '".$amen_ID[$i]."', '".$amen_Name[$i]."', '".$amen_Qty[$i]."', '$amount')";
			
			$run_query_save = mysqli_query($db, $query_save);
		}
	
		//delete 0 quantity
		$segre = "SELECT * FROM amen_transaction WHERE AmenQuantity = 0 AND TransactionCode = '$TransactionCode'";
		$run_segre = mysqli_query($db, $segre);
		if(mysqli_num_rows($run_segre)>0){
			while($segre_rows = mysqli_fetch_array($run_segre)){
				$idd = $segre_rows['AmenID'];
				$segre_del = "DELETE FROM amen_transaction WHERE AmenID = '$idd'  AND TransactionCode = '$TransactionCode'";
				$run_segre_del = mysqli_query($db, $segre_del);
			}
		}
		
		//-------------------------------------------------------------------------------------------------------------------------

	$query_sum = "SELECT SUM(AmenRates) AS Total_Amen_Rates FROM amen_transaction WHERE TransactionCode = '$TransactionCode'";
    $run_query_sum = mysqli_query($db, $query_sum);
    $row_sum = mysqli_fetch_assoc($run_query_sum);
    $amentotal = $row_sum['Total_Amen_Rates'];

    $from = strtotime($Arrival);
    $to = strtotime($Departure);
    $datediff = $to - $from;
    $date_difference = round($datediff/(60*24*60));
    $nights = $date_difference;
    $Subtotal = $nights * $price; //room total
    $SUbtotal_with_amen = $Subtotal + $amentotal;
    $totalRates = $SUbtotal_with_amen - ($SUbtotal_with_amen*($Discount/100));

     
	//update transaction
	$query_trans_update = "UPDATE transaction SET Arrival = '$Arrival', Departure='$Departure',
	TotalRates = '$totalRates'  WHERE TransactionCode = $TransactionCode";
	$run_query_trans_update = mysqli_query($db, $query_trans_update);

	//update guest
	$query_guest_update = "UPDATE guest SET Name = '$Name', Nationality='$Nationality', Birthdate='$Birthdate', PNumber='$PNumber',
	Email='$Email', Address='$Address', Company='$Company', CompanyAddress = '$CompanyAddress', Origin = '$Origin',
	Passport = '$Passport', IssuedAt = '$IssuedAt', GuestNumber = '$GuestNumber', GuestNumber2 = '$GuestNumber2'  WHERE GuestID = $Guest_ID";
	$run_guest_update = mysqli_query($db, $query_guest_update);

	//update recent_guest
	$query_recent_guest_update = "UPDATE recent_guest SET Name = '$Name', Nationality='$Nationality', Birthdate='$Birthdate', PNumber='$PNumber',
	Email='$Email', Address='$Address', Company='$Company', CompanyAddress = '$CompanyAddress', Origin = '$Origin',
	Passport = '$Passport', IssuedAt = '$IssuedAt', Discount= '$Discount', GuestNumber = '$GuestNumber', GuestNumber2 = '$GuestNumber2'  WHERE TransactionCode = $TransactionCode";
	$run_query_recent_guest_update = mysqli_query($db, $query_recent_guest_update);

	

    if ($run_query_trans_update && $run_guest_update && $run_query_recent_guest_update  )  {
		 
		$_SESSION['BookingMessage'] = '
					
					<div class="alert alert-success alert-dismissable" id="flash-msg">
					<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
					<h5>Booking Updated successfully</h5>
					</div>
			
			';
			mysqli_close($db);

 		echo "<script>window.location.href='../Staff/booking';</script>";

	} else {
		$_SESSION['BookingMessage'] = '
				<div class="alert alert-danger alert-dismissable" id="flash-msg">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<h5>Some error occured, please try again!</h5>
				</div>
		
			';

			
			mysqli_close($db);

			echo "<script>window.location.href='../Staff/booking';</script>";

	}
	mysqli_close($db);
}


//customer reservation **new reserve process** -----------------------------------------------------------------
if (isset($_POST['Reserve_Button'])) {

    $RRoomID = $_POST['RoomID'];

	$Accommodation = $_POST['Accommodation'];

    $GuestNumber = $_POST['GuestNumber'];
	$GuestNumber2 = $_POST['GuestNumber2'];

    $Name = $_POST['Name'];
    $Nationality = $_POST['Nationality'];
    $Birthdate = $_POST['Birthdate'];
    $PNumber = $_POST['PNumber'];
    $Email = $_POST['Email'];
    $Address = $_POST['Address'];
    $Company = $_POST['Company'];
    $CompanyAddress = $_POST['CompanyAddress'];
    $Origin = $_POST['Origin'];
    $Passport = $_POST['Passport'];
    $IssuedAt = $_POST['IssuedAt'];
    $Requests = $_POST['Requests'];
    $Downpayment = $_POST['Downpayment'];

	$RAccommodation = $_POST['Accommodation'];
 
	$RTransactionDate = $_POST['TransactionDate'];
	$RTransactionTime = $_POST['TransactionTime'];
	$RTransactionCode = $_POST['TransactionCode'];

	$RArrivalR = $_POST['Arrival'];
	$RDepartureR = $_POST['Departure'];

    $wID = $_POST['WebUser'];
    $totalRates = $_POST['TotalRates'];


	$ReserveStatus = "Approved";

	$query_guest_save = "INSERT INTO guest (GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt,  RoomID, TransactionCode, wID) 
		VALUES ('$GuestNumber', '$GuestNumber2', '$Name', '$Nationality', '$Birthdate', '$PNumber',  '$Email', '$Address', '$Company', '$CompanyAddress', '$Origin', '$Passport', '$IssuedAt', '$RRoomID', 
		'$RTransactionCode', '$wID')";
	$run_query_guest_save = mysqli_query($db, $query_guest_save);


	$query_1 = "SELECT * FROM guest WHERE TransactionCode = $RTransactionCode";
	$query_run1 = mysqli_query($db, $query_1);
	$res = mysqli_fetch_assoc($query_run1);

 	$RGuestID = $res['GuestID'];

	$insertArrival = date("Y-m-d",strtotime($RArrivalR));
	$insertDeparture = date("Y-m-d",strtotime($RDepartureR));

	$query_reservation_transaction = "INSERT INTO reservation (TransactionDate, TransactionTime, TransactionCode, GuestID, RoomID, Accommodationtype, Arrival, Departure, TotalRates, Downpayment, ReservationStatus, Requests) 
	VALUES ('$RTransactionDate','$RTransactionTime','$RTransactionCode', '$RGuestID', '$RRoomID', '$RAccommodation', '$insertArrival', '$insertDeparture', '$totalRates', '$Downpayment', '$ReserveStatus', '$Requests')";
	$run_query_reservation_transaction = mysqli_query($db, $query_reservation_transaction);


	$sql_transfer_to_recent_guest = "INSERT INTO recent_guest (
		GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt,  RoomID, TransactionCode, wID)		
		SELECT 
		GuestNumber, GuestNumber2, Name, Nationality, Birthdate, PNumber, Email, Address, Company, CompanyAddress, Origin, Passport, IssuedAt,  RoomID, TransactionCode, wID
		FROM guest WHERE TransactionCode='$RTransactionCode'";
		
	$run_sql_transfer_to_recent_guest = mysqli_query($db, $sql_transfer_to_recent_guest);

	$query_Reset_Guest = "UPDATE guest SET RoomID = '0', TransactionCode='', wID = '0' WHERE wID = $wID";
	$run_query_Reset_Guest = mysqli_query($db, $query_Reset_Guest);


	if ($run_query_guest_save && $run_query_reservation_transaction && $run_sql_transfer_to_recent_guest && $run_query_Reset_Guest) {
		$_SESSION['TransReservationMessage'] = '
			
			<div class="alert alert-success alert-dismissable" id="flash-msg">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h5>Room reservation request sent successfully!</h5>
			</div>
	
	';

 		echo "<script>window.location.href='../transaction';</script>";

	} else {
		$_SESSION['ReservationMessage'] = '
		<div class="alert alert-danger alert-dismissable" id="flash-msg">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h5>Some error occured, please try again!</h5>
		</div>

	';

 		echo "<script>window.location.href='..';</script>";

	}


	mysqli_close($db);
}
//TO BE CONTINUED......
