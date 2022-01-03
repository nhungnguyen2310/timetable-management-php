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
		<form action="" method="POST" id="form">
			<div class="logout">
				<input class="button_logout" name="logout" type="submit" value="Đăng xuất">
			</div>
			<div class="form">
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Khóa"?></label>
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
						<label class="label"><?php echo "Từ khóa"?></label>
					</div>
					<input type="text" id="search" class="form_item_input" name="keyword" placeholder="Nhập từ khóa">
				</div>
				<div>
					<input class="button" name="search" id="search_button" type="submit" value="Tìm kiếm">
				</div>
			</div>
		
			<div class="information">
				<span><?php echo "Số lớp học tìm thấy: " . count($schedules) . ""?></span>
			</div>
			<div class="details">
				<table>
					<tr>
						<th><?php echo "No."?></th>
						<th><?php echo "Khóa"?></th>
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
								echo "<td><div><input class='button' name='delete_" . $i . "' type='submit' value='Xóa'><input class='button' name='edit_" . $i . "' type='submit' value='Sửa'></div></td>"; 
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
			<div>
				<input class="button" name="home" type="submit" value="Trở về trang chủ">
			</div>
		</form>
	</div>
</body>
</html>