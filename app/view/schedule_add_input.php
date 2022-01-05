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
	$schlr = 0;
	$sbjct = 0;
	$tchr = 0;
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
				<span><?php echo "THÊM THÔNG TIN LỚP HỌC"?></span>
			</div>
			<div class="form_error_">
				<?php
					if (isset($errors["duplicate"])) {
						echo '<span class="error">' . $errors["duplicate"] . '</span>';
					}
				?>
			</div>
			<div class="form">
				<div class="form_error">
					<?php
						if (isset($errors["school_year"])) {
							echo '<span class="error">' . $errors["school_year"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Năm học"?></label>
					</div>
					<select class="select_box" name="add_school_year" id="add_school_year" onchange="reload(this.form)">
						<?php
							$years = array("--Chọn năm học--", "Năm 1", "Năm 2", "Năm 3", "Năm 4");
							if (!isset($errors["duplicate"])) $year = $schlr;
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
				<div class="form_error">
					<?php
						if (isset($errors["subject"])) {
							echo '<span class="error">' . $errors["subject"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Môn học"?></label>
					</div>
					<select class="select_box" name="add_subject" id="add_subject" onchange="reload(this.form)">
						<?php
							$subjects = getSubjects("Năm " . $schlr);
							if (!isset($errors["duplicate"])) $subject = $sbjct;
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
				<div class="form_error">
					<?php
						if (isset($errors["teacher"])) {
							echo '<span class="error">' . $errors["teacher"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Giáo viên"?></label>
					</div>
					<select class="select_box" name="add_teacher" id="add_teacher" onchange="reload(this.form)">
						<?php
							$teachers = getTeachers(getSubjectID($subjects[$sbjct], "Năm " . $schlr));
							if (!isset($errors["duplicate"])) $teacher = $tchr;
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
				<div class="form_error">
					<?php
						if (isset($errors["weekday"])) {
							echo '<span class="error">' . $errors["weekday"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Thứ"?></label>
					</div>
					<select class="select_box" name="add_weekday">
						<?php
							$weekdays = array("--Chọn ngày học--", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7");
							$chose = "";
							foreach ($weekdays as $key => $value) {
								if (isset($weekday) && $weekday == $key && !isset($errors["duplicate"])) {
									$chose = "selected";
								} else {
									$chose = "";
								}
								echo '<option value=' . $key . ' ' . $chose . '>' . $value . '</option>';
							}
						?>
					</select>
				</div>
				<div class="form_error">
					<?php
						if (isset($errors["lesson"])) {
							echo '<span class="error">' . $errors["lesson"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Tiết học"?></label>
					</div>
					<div class="form_item_table">
						<table>
							<tr>
								<?php
									$checked = "";
									$j = 0;
									for ($i = 1; $i <= 10; $i++) {
										if (isset($_POST["add_lesson_" . $i]) && !isset($errors["duplicate"])) {
											$checked = "checked";
										} else {
											$checked = "";
										}
										echo "<td><input type='checkbox' id='lesson_" . $i . "' name='add_lesson_" . $i . "' value='true' " . $checked . ">";
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
				<div class="form_error">
					<?php
						if (isset($errors["notes"])) {
							echo '<span class="error">' . $errors["notes"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Ghi chú"?></label>
					</div>
					<textarea class="form_item_textarea" name="add_notes" placeholder="Nhập ghi chú" maxlength="1000"><?php if (isset($notes) && !isset($errors["duplicate"])) { echo $notes; }?></textarea>
				</div>
			</div>
			<div class="buttons">
				<input class="button" name="home" type="submit" value="Quay lại">
				<input class="button" name="add_submit" type="submit" value="Xác nhận">
			</div>
		</form>
	</div>
</body>

<script>
	function reload(form) {
		var school_year = form.add_school_year.options[form.add_school_year.options.selectedIndex].value;
		var subject = form.add_subject.options[form.add_subject.options.selectedIndex].value;
		var teacher = form.add_teacher.options[form.add_teacher.options.selectedIndex].value;
		self.location = 'schedule.php?school_year=' + school_year + "&subject=" + subject + "&teacher=" + teacher;
	}

	function disable() {
		<?php
			if ($schlr != 0) {
				echo "document.form.add_subject.disabled = false;";
			} else {
				echo "document.form.add_subject.disabled = true;";
			}
			if ($sbjct != 0) {
				echo "document.form.add_teacher.disabled = false;";
			} else {
				echo "document.form.add_teacher.disabled = true;";
			}
		?>
	}
</script>
</html>