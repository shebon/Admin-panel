<?php
include('top.php');

if (isset($_GET['type']) && $_GET['type'] !== '' && isset($_GET['id']) && $_GET['id'] > 0) {
	$type = get_safe_value($_GET['type']);
	$id = get_safe_value($_GET['id']);
	if ($type == 'delete') {
		mysqli_query($con, "delete from course where id='$id'");
		redirect('course.php');
	}
	if ($type == 'active' || $type == 'deactive') {
		$status = 1;
		if ($type == 'deactive') {
			$status = 0;
		}
		mysqli_query($con, "update course set status='$status' where id='$id'");
		redirect('course.php');
	}
}

$sql = "select * from course order by id";
$res = mysqli_query($con, $sql);

?>
<div class="card">
	<div class="card-body">
		<h1 class="grid_title">Course Master</h1>
		<a href="manage_course.php" class="add_link">Add course</a>
		<div class="row grid_box">

			<div class="col-12">
				<div class="table-responsive">
					<table id="order-listing" class="table">
						<thead>
							<tr>
								<th width="10%">S.No #</th>
								<th width="50%">course</th>
								<th width="15%">Order Number</th>
								<th width="25%">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (mysqli_num_rows($res) > 0) {
								$i = 1;
								while ($row = mysqli_fetch_assoc($res)) {
							?>
									<tr>
										<td><?php echo $i ?></td>
										<td><?php echo $row['course'] ?></td>
										<td><?php echo $row['id'] ?></td>
										<td>
											<a href="manage_course.php?id=<?php echo $row['id'] ?>"><label class="badge badge-success hand_cursor">Edit</label></a>&nbsp;
											<?php
											if ($row['status'] == 1) {
											?>
												<a href="?id=<?php echo $row['id'] ?>&type=deactive"><label class="badge badge-danger hand_cursor">Active</label></a>
											<?php
											} else {
											?>
												<a href="?id=<?php echo $row['id'] ?>&type=active"><label class="badge badge-info hand_cursor">Deactive</label></a>
											<?php
											}

											?>
											&nbsp;
											<a href="?id=<?php echo $row['id'] ?>&type=delete"><label class="badge badge-danger delete_red hand_cursor">Delete</label></a>
										</td>

									</tr>
								<?php
									$i++;
								}
							} else { ?>
								<tr>
									<td colspan="5">No data found</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>