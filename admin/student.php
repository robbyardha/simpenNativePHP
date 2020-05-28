<!DOCTYPE html>
<?php
require 'validator.php';
require_once 'conn.php'
?>
<html lang = "en">
	<head>
		<title>Admin File Management System</title>
		<meta charset = "utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
		<link rel = "stylesheet" type = "text/css" href = "css/jquery.dataTables.css" />
		<link rel = "stylesheet" type = "text/css" href = "css/style.css" />
	</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" style="background-color:blue;">
		<div class="container-fluid">
			<label class="navbar-brand" id="title">Admin File Management System</label>
			<?php
$query = mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = '$_SESSION[user]'") or die(mysqli_error());
$fetch = mysqli_fetch_array($query);
?>
			<ul class = "nav navbar-right">
				<li class = "dropdown">
					<a class = "user dropdown-toggle" data-toggle = "dropdown" href = "#">
						<span class = "glyphicon glyphicon-user"></span>
						<?php
echo $fetch['firstname'] . " " . $fetch['lastname'];
?>
						<b class = "caret"></b>
					</a>
				<ul class = "dropdown-menu">
					<li>
						<a href = "logout.php"><i class = "glyphicon glyphicon-log-out"></i> Logout</a>
					</li>
				</ul>
				</li>
			</ul>
		</div>
	</nav>
	<?php include 'sidebar.php'?>

	<div id = "content">
		<br /><br /><br />
		<div class="alert alert-info"><h3>Teacher</h3></div>

		<a href="import.php" class="btn btn-primary" role="button">IMPORT DATA</a>
		<a href="./download/format_upload_guru.xls" class="btn btn-warning" role="button">DOWNLOAD FORMAT GURU</a>
		<a href="./download/format_upload_karyawan.xls" class="btn btn-warning" role="button">DOWNLOAD FORMAT KARYAWAN</a>
		<button class="btn btn-success" data-toggle="modal" data-target="#form_modal"><span class="glyphicon glyphicon-plus"></span> Tambah Guru</button>

		<br /><br />
		<table id = "table" class="table table-bordered">
			<thead>
				<tr>
					<th>Id Guru</th>
					<th>Nama Awal</th>
					<th>Nama Akhir</th>
					<th>Jenis Kelamin</th>
					<th>Password</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
$query = mysqli_query($conn, "SELECT * FROM `student`") or die(mysqli_error());
while ($fetch = mysqli_fetch_array($query)) {
    ?>
					<tr class="del_student<?php echo $fetch['stud_id'] ?>">
						<td><?php echo $fetch['stud_no'] ?></td>
						<td><?php echo $fetch['firstname'] ?></td>
						<td><?php echo $fetch['lastname'] ?></td>
						<td><?php echo $fetch['gender'] ?></td>
						<td>********</td>
						<td><center><button class="btn btn-warning" data-toggle="modal" data-target="#edit_modal<?php echo $fetch['stud_id'] ?>"><span class="glyphicon glyphicon-edit"></span> Edit</button>
						<button class="btn btn-danger btn-delete" id="<?php echo $fetch['stud_id'] ?>" type="button"><span class="glyphicon glyphicon-trash"></span> Delete</button></center></td>
					</tr>
	<div class="modal fade" id="edit_modal<?php echo $fetch['stud_id'] ?>" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form method="POST" action="update_student.php">
					<div class="modal-header">
						<h4 class="modal-title">Update Teacher</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label>ID Guru</label>
								<input type="hidden" name="stud_id" value="<?php echo $fetch['stud_id'] ?>" class="form-control"/>
								<input type="number" name="stud_no" value="<?php echo $fetch['stud_no'] ?>" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Nama Awal</label>
								<input type="text" name="firstname" value="<?php echo $fetch['firstname'] ?>" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Nama Akhir</label>
								<input type="text" name="lastname" value="<?php echo $fetch['lastname'] ?>" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="gender" class="form-control" required="required">
									<option value=""></option>
									<option value="Laki-laki">Laki-Laki</option>
									<option value="Perempuan">Perempuan</option>
								</select>
							</div>
							<br />
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" class="form-control" required="required"/>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
						<button name="update" class="btn btn-warning" ><span class="glyphicon glyphicon-save"></span> Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
				<?php
}
?>
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="modal_confirm" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">System</h3>
				</div>
				<div class="modal-body">
					<center><h4 class="text-danger">All file of the student will be deleted too...</h4></center>
					<center><h3 class="text-danger">Are you sure you want to delete this data?</h3></center>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" id="btn_yes">Yes</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="form_modal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form method="POST" action="save_student.php">
					<div class="modal-header">
						<h4 class="modal-title">TAMBAH GURU</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label>ID Guru</label>
								<input type="number" name="stud_no" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Nama Awal</label>
								<input type="text" name="firstname" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Nama Akhir</label>
								<input type="text" name="lastname" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="gender" class="form-control" required="required">
									<option value=""></option>
									<option value="Laki-laki">Laki-Laki</option>
									<option value="Perempuan">Perempuan</option>
								</select>
							</div>

							<br />
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" class="form-control" required="required"/>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
						<button name="save" class="btn btn-success" ><span class="glyphicon glyphicon-save"></span> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id = "footer">
		<label class = "footer-title">&copy; Copyright ICT_SMAM1TA <?php echo date("Y", strtotime("+8 HOURS")) ?></label>
	</div>
<?php include 'script.php'?>
<script type="text/javascript">
$(document).ready(function(){
	$('.btn-delete').on('click', function(){
		var stud_id = $(this).attr('id');
		$("#modal_confirm").modal('show');
		$('#btn_yes').attr('name', stud_id);
	});
	$('#btn_yes').on('click', function(){
		var id = $(this).attr('name');
		$.ajax({
			type: "POST",
			url: "delete_student.php",
			data:{
				stud_id: id
			},
			success: function(){
				$("#modal_confirm").modal('hide');
				$(".del_student" + id).empty();
				$(".del_student" + id).html("<td colspan='6'><center class='text-danger'>Deleting...</center></td>");
				setTimeout(function(){
					$(".del_student" + id).fadeOut('slow');
				}, 1000);
			}
		});
	});
});
</script>
</body>
</html>