<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TTB</title>
	<style type="text/css">
		<?php include '../../web/css/detail.css'; ?>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap');
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<?php
	if (isset($_SESSION["_edit_schedule"])) {
		unset($_SESSION["_edit_schedule"]);
		$schlr = substr(getSchoolYear(getSubjectID_($schedule["teacher_id"])), 5);
		$subjects = getSubjects("Năm " . $schlr);
		$sbjct = getIndex(getSubjectName(getSubjectID_($schedule["teacher_id"])), $subjects);
		$teachers = getTeachers(getSubjectID_($schedule["teacher_id"]));
		$tchr = getIndex(getTeacherName($schedule["teacher_id"]), $teachers);
	}
	if (isset($_GET["school_year"])) {
		$schlr = $_GET["school_year"];
	}
	if (isset($_GET["school_year"])) {
		if ($schlr == 0) {
			$sbjct = 0;
		} else {
			$sbjct = $_GET["subject"];
		}
	}
	if (isset($_GET["school_year"])) {
		if ($sbjct == 0) {
			$tchr = 0;
		} else {
			$tchr = $_GET["teacher"];
		}
	}
?>

<body onload="disable()">
	<div class="container">
		<form action="" method="POST" name="form">
			<div class="form_title">
				<span><?php echo "CHỈNH SỬA THÔNG TIN LỚP HỌC"?></span>
			</div>
			<div class="form_error">
				<?php
					if (!empty($error)) {
						echo '<span class="error">' . $error . '</span>';
					}
				?>
			</div>
			<div class="form">
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Khóa"?></label>
					</div>
					<select class="select_box" name="new_school_year" onchange="reload(this.form)">
						<?php
							$years = array("--Chọn năm học--", "Năm 1", "Năm 2", "Năm 3", "Năm 4");
							$year = $schlr;
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
					<select class="select_box" name="new_subject" onchange="reload(this.form)">
						<?php
							$subjects = getSubjects("Năm " . $schlr);
							$subject = $sbjct;
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
					<select class="select_box" name="new_teacher" onchange="reload(this.form)">
						<?php
							$teachers = getTeachers(getSubjectID($subjects[$sbjct], "Năm " . $schlr));
							$teacher = $tchr;
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
					<div class="form_item_title">
						<label class="label"><?php echo "Thứ"?></label>
					</div>
					<select class="select_box" name="new_weekday">
						<?php
							$weekdays = array("--Chọn ngày học--", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7");
							$weekday = getIndex($schedule["weekday"], $weekdays);
							$chose = "";
							foreach ($weekdays as $key => $value) {
								if (isset($weekday) && ($weekday == $key)) {
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
						<label class="label"><?php echo "Tiết học"?></label>
					</div>
					<div class="form_item_table">
						<table>
							<tr>
								<?php
									$lessons = explode(", ", $schedule["lesson"]);
									$checked = "";
									$j = 0;
									for ($i = 1; $i <= 10; $i++) {
										if (in_array($i, $lessons)) {
											$checked = "checked";
										} else {
											$checked = "";
										}
										echo "<td><input type='checkbox' id='lesson_" . $i . "' name='new_lesson_" . $i . "' value='true' " . $checked . ">";
										echo "<label for='lesson_" . $i . "'>Tiết " . $i . "</label></td>";
										$j++;
										if ($j % 2 == 0) {
											echo "</tr><tr>";
										}
									}
								?>
							</tr>
						</table>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Ghi chú"?></label>
					</div>
					<input class="form_item_input" name="new_notes" placeholder="Nhập ghi chú" value="<?php if (isset($notes)) { echo $notes; }?>">
				</div>
			</div>
			</div>
			<div class="buttons">
				<input class="button" name="back" type="submit" value="Quay lại">
				<input class="button" name="edit_submit" type="submit" value="Xác nhận">
			</div>
		</form>
	</div>
</body>

<script>
	function reload(form) {
		var school_year = form.new_school_year.options[form.new_school_year.options.selectedIndex].value;
		var subject = form.new_subject.options[form.new_subject.options.selectedIndex].value;
		var teacher = form.new_teacher.options[form.new_teacher.options.selectedIndex].value;
		self.location = 'schedule.php?school_year=' + school_year + "&subject=" + subject + "&teacher=" + teacher;
	}

	function disable() {
		<?php
			if ($schlr != 0) {
				echo "document.form.new_subject.disabled = false;";
			} else {
				echo "document.form.new_subject.disabled = true;";
				echo "document.form.new_teacher.disabled = true;";
			}
			if ($sbjct != 0) {
				echo "document.form.new_teacher.disabled = false;";
			} else {
				echo "document.form.new_teacher.disabled = true;";
			}
		?>
	}
</script>
</html>