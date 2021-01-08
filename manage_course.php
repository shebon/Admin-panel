<?php
include('top.php');
$msg = "";
$course = "";
$order_number = "";
$id = "";

if (isset($_GET['id']) && $_GET['id'] > 0) {
	$id = get_safe_value($_GET['id']);
	$row = mysqli_fetch_assoc(mysqli_query($con, "select * from course where id='$id'"));
	$course = $row['course'];
	$order_number = $row['order_number'];
}

if (isset($_POST['submit'])) {
	$course = get_safe_value($_POST['course']);
	$order_number = get_safe_value($_POST['order_number']);
	$added_on = date('Y-m-d h:i:s');

	if ($id == '') {
		$sql = "select * from course where course='$course'";
	} else {
		$sql = "select * from course where course='$course' and id!='$id'";
	}
	if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
		$msg = "course already added";
	} else {
		if ($id == '') {
			mysqli_query($con, "insert into course(course,order_number,status,added_on) values('$course','$order_number',1,'$added_on')");
		} else {
			mysqli_query($con, "update course set course='$course', order_number='$order_number' where id='$id'");
		}

		redirect('course.php');
	}
}
?>
<div class="row">
	<h1 class="grid_title ml10 ml15">Manage course</h1>
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<form class="forms-sample" method="post">
					<div class="form-group">
						<label for="exampleInputName1">course</label>
						<input type="text" class="form-control" placeholder="course" name="course" required value="<?php echo $course ?>">
						<div class="error mt8"><?php echo $msg ?></div>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail3" required>Order Number</label>
						<input type="textbox" class="form-control" placeholder="Order Number" name="order_number" value="<?php echo $order_number ?>">
					</div>

					<button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>

</div>

<?php include('footer.php'); ?>