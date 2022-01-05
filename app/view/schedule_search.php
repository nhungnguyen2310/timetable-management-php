<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TTB</title>
	<style type="text/css">
		<?php include '../../web/css/style.css'; ?>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap');
	</style>
</head>

<body>
	<div class="container">
		<form action="" method="POST">
			<div class="logout">
				<input class="button_logout" name="logout" type="submit" value="Đăng xuất">
			</div>
		</form>
		<form action="" method="GET">
			<div class="form">
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Năm học"?></label>
					</div>
					<select class="select_box" name="school_year">
						<?php
							$years = array("--Chọn năm học--", "Năm 1", "Năm 2", "Năm 3", "Năm 4");
							$chose = "";
							foreach ($years as $key => $value) {
								if (isset($year) && ($year == $key)) {
									$chose = "selected";
								} else {
									$chose = "";
								}
								echo '<option value=' . $key . ' ' . $chose . '>' . $value . '</option>';
							}
						?>
					</select>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Môn học"?></label>
					</div>
					<select class="select_box" name="subject">
						<?php
							$chose = "";
							foreach ($subjects as $key => $value) {
								if (isset($subject) && ($subject == $key)) {
									$chose = "selected";
								} else {
									$chose = "";
								}
								echo '<option value=' . $key . ' ' . $chose . '>' . $value . '</option>';
							}
						?>
					</select>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Giáo viên"?></label>
					</div>
					<select class="select_box" name="teacher">
						<?php
							$chose = "";
							foreach ($teachers as $key => $value) {
								if (isset($teacher) && ($teacher == $key)) {
									$chose = "selected";
								} else {
									$chose = "";
								}
								echo '<option value=' . $key . ' ' . $chose . '>' . $value . '</option>';
							}
						?>
					</select>
				</div>
				<div class="form_item">
					<button class="button" name="search" id="search_button" type="submit" value="true"><?php echo "Tìm kiếm"?></button>
				</div>
			</div>
		</form>
		<form action="" method="POST">
			<?php
				$_school_year = "";
				$_subject = "";
				$_teacher = "";
				if (isset($_GET["search"])) {
					if ($_GET["school_year"] != 0) {
						$_school_year = $years[$_GET["school_year"]];
					}
					if ($_GET["subject"] != 0) {
						$_subject = $subjects[$_GET["subject"]];
					}
					if ($_GET["teacher"] != 0) {
						$_teacher = $teachers[$_GET["teacher"]];
					}
				}
				$data = getSchedules($_school_year, $_subject, $_teacher);
				$count = $data[0];
				$schedules = $data[1];
			?>
			<div class="information">
				<span><?php echo "Số lớp học tìm thấy: " . $count . ""?></span>
			</div>
			<div class="details">
				<table>
					<tr>
						<th><?php echo "No."?></th>
						<th><?php echo "Năm học"?></th>
						<th><?php echo "Môn học"?></th>
						<th><?php echo "Giáo viên"?></th>
						<th><?php echo "Thứ"?></th>
						<th><?php echo "Tiết học"?></th>
						<th><?php echo "Ghi chú"?></th>
						<th><?php echo "Hành động"?></th>
					</tr>
					<?php
						if ($count > 0) {
							for ($i = 0; $i < $count; $i++) {
								$schedule = $schedules[$i];
								echo "<tr>";
								echo "<td>" . $i+1 . "</td>";
								echo "<td>" . getSchoolYear(getSubjectID_($schedule["teacher_id"])) . "</td>";
								echo "<td>" . getSubjectName(getSubjectID_($schedule["teacher_id"])) . "</td>";
								echo "<td>" . getTeacherName($schedule["teacher_id"]) . "</td>";
								echo "<td>" . $schedule["weekday"] . "</td>";
								echo "<td>" . $schedule["lesson"] . "</td>";
								echo "<td>" . $schedule["notes"] . "</td>";
								echo "<td><div class='buttons2'><button class='button' name='delete_" . $i . "' type='submit' value='Xóa' onclick='return confirm(`Bạn chắc chắn muốn xóa thông tin lớp học?`)'>Xóa</button><button class='button' name='edit_" . $i . "' type='submit' value='Sửa'>Sửa</button></div></td>"; 
								echo "</tr>";
							}
						} else {
							echo "<tr>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "<td>&nbsp;</td>";
							echo "</tr>";
						}
					?>
				</table>
			</div>
			<div class="form_item">
				<button class="button" name="home" type="submit" value="Trở về trang chủ"><?php echo "Trở về trang chủ"?></button>
			</div>
		</form>
	</div>
</body>
</html>