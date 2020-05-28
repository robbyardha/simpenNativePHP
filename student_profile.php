<!DOCTYPE html>
<?php
require 'validator.php';
require_once 'admin/conn.php'
?>
<html lang = "en">
	<head>
		<title>Teacher File Management System</title>
		<meta charset = "utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel = "stylesheet" type = "text/css" href = "admin/css/bootstrap.css" />
		<link rel = "stylesheet" type = "text/css" href = "admin/css/jquery.dataTables.css" />
		<link rel = "stylesheet" type = "text/css" href = "admin/css/style.css" />
	</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" style="background-color:blue;">
		<div class="container-fluid">
			<label class="navbar-brand" id="title">Teacher File Management System</label>
			<img src="barbar.png" alt="" width="50px" height="65px">
		</div>
	</nav>
	<div class="col-md-4">
		<?php
$query = mysqli_query($conn, "SELECT * FROM `student` WHERE `stud_id` = '$_SESSION[student]'") or die(mysqli_error());
$fetch = mysqli_fetch_array($query);
?>
		<div class="panel panel-default" style="background-color:#393f4d;" id="panel-margin">
			<div class="panel-heading" style="background-color:#feda6a;">
				<center><h1 class="panel-title" style="color:red;">Teacher Profile</h1></center>
			</div>
			<div class="panel-body">
				<h4 style="color:#fff;">ID Guru : <label class="pull-right"><?php echo $fetch['stud_no'] ?></label></h4>
				<h4 style="color:#fff;">Nama: <label class="pull-right"><?php echo $fetch['firstname'] . " " . $fetch['lastname'] ?></label></h4>
				<h4 style="color:#fff;">Jenis Kelamin: <label class="pull-right"><?php echo $fetch['gender'] ?></label></h4>
				<!-- <h4 style="color:#fff;">Year & Section: <label class="pull-right"><?php echo $fetch['yr&sec'] ?></label></h4> -->
				<h3 style="color:#fff;">Upload File</h3>
				<form method="POST" enctype="multipart/form-data" action="save_file.php">
					<input type="file" name="file" size="4" style="background-color:#fff;" required="required" />
					<br />
					<input type="hidden" name="stud_no" value="<?php echo $fetch['stud_no'] ?>"/>
					<button class="btn btn-success btn-sm" name="save"><span class="glyphicon glyphicon-plus"></span> Tambah File</button>
				</form>
				<br style="clear:both;"/>
				<hr style="border-top:1px solid #fff;"/>
				<button class="btn btn-danger pull-right" data-toggle="modal" data-target="#modal_confirm"><span class="glyphicon glyphicon-log-out"></span> Logout</button>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default" style="margin-top:100px;">
			<div class="panel-body">
				<table id="table" class="table table-bordered">
					<thead>
						<tr>
							<th>Nama File</th>
							<th>Type FIle</th>
							<th>Date Uploaded</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$stud_no = $fetch['stud_no'];
							$query = mysqli_query($conn, "SELECT * FROM `storage` WHERE `stud_no` = '$stud_no'") or die(mysqli_error());
							while ($fetch = mysqli_fetch_array($query)) {
    					?>
						<tr class="del_file<?php echo $fetch['store_id'] ?>">
							<td><?php echo substr($fetch['filename'], 0, 30) . "..." ?></td>
							<td><?php echo $fetch['file_type'] ?></td>
							<td><?php echo $fetch['date_uploaded'] ?></td>
							<td><a href="download.php?store_id=<?php echo $fetch['store_id'] ?>" class="btn btn-success"><span class="glyphicon glyphicon-download"></span> Download</a> | <button class="btn btn-danger btn_remove" type="button" id="<?php echo $fetch['store_id'] ?>"><span class="glyphicon glyphicon-trash"></span> Remove</button></td>
						</tr>
						<?php
}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div id = "footer">
		<label class = "footer-title">&copy; Copyright ICT_SMAM1TA <?php echo date("Y", strtotime("+8 HOURS")) ?></label>
	</div>
	<div class="modal fade" id="modal_confirm" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">System</h3>
				</div>
				<div class="modal-body">
					<center><h4 class="text-danger">Are you sure you want to logout?</h4></center>
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-success" data-dismiss="modal">Cancel</a>
					<a href="logout.php" class="btn btn-danger">Logout</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_remove" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">System</h3>
				</div>
				<div class="modal-body">
					<center><h4 class="text-danger">Are you sure you want to remove this file?</h4></center>
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-success" data-dismiss="modal">No</a>
					<button type="button" class="btn btn-danger" id="btn_yes">Yes</button>
				</div>
			</div>
		</div>
	</div>
<?php include 'script.php'?>
<script type="text/javascript">
$(document).ready(function(){
	$('.btn_remove').on('click', function(){
		var store_id = $(this).attr('id');
		$("#modal_remove").modal('show');
		$('#btn_yes').attr('name', store_id);
	});

	$('#btn_yes').on('click', function(){
		var id = $(this).attr('name');
		$.ajax({
			type: "POST",
			url: "remove_file.php",
			data:{
				store_id: id
			},
			success: function(data){
				$("#modal_remove").modal('hide');
				$(".del_file" + id).empty();
				$(".del_file" + id).html("<td colspan='4'><center class='text-danger'>Deleting...</center></td>");
				setTimeout(function(){
					$(".del_file" + id).fadeOut('slow');
				}, 1000);
			}
		});
	});
});
</script>
</body>
</html>