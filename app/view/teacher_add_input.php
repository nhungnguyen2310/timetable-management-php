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

<body>
	<div class="container">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form_title">
				<span><?php echo "THÊM THÔNG TIN GIÁO VIÊN"?></span>
			</div>
			<div class="form">
				<div class="form_error_">
					<?php
						if (isset($errors["duplicate"])) {
							echo '<span class="error">' . $errors["duplicate"] . '</span><br>';
						}
					?>
				</div>
				<div class="form_error">
					<?php
						if (isset($errors["name"])) {
							echo '<span class="error">' . $errors["name"] . '</span><br>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Tên giáo viên"?></label>
					</div>
					<input class="form_item_input" name="add_name" placeholder="Nhập tên giáo viên" maxlength="100" value="<?php if (!empty($name) && !isset($errors["duplicate"])) { echo $name; }?>">
				</div>
				<div class="form_error">
					<?php
						if (isset($errors["subject_id"])) {
							echo '<span class="error">' . $errors["subject_id"] . '</span><br>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Chuyên ngành"?></label>
					</div>
					<select class="select_box form_item_input" name="add_subject_id">
						<?php
							$subjects = getSubjects();
							if ($subject_id != -1) $subject = getSubjectName($subject_id);
							$chose = "";
							foreach ($subjects as $key => $value) {
								if (isset($subject) && ($subject == $key || $subject == $value) && !isset($errors["duplicate"])) {
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
						if (isset($errors["degree"])) {
							echo '<span class="error">' . $errors["degree"] . '</span><br>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Học vị"?></label>
					</div>
					<select class="select_box" name="add_degree">
						<?php
							$chose = "";
							foreach ($degrees as $key => $value) {
								if (isset($degree) && ($degree == $key || $degree == $value) && !isset($errors["duplicate"])) {
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
						if (isset($errors["avatar"])) {
							echo '<span class="error">' . $errors["avatar"] . '</span><br>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Ảnh đại diện"?></label>
					</div>
					<div class="form_item_image">
						<div class="form_item_avatar">
							<?php
								$avt = "temp.jpg";
								if (!empty($avatar)) $avt = "tmp/" . $avatar;
								echo "<img id='add_avatar' src='../../web/avatar/$avt'>"
							?>
						</div>
						<div class="form_item_file" id="browse">
							<div class="form_item_filename" id="filename"></div>
							<div class="form_item_button">
								<label class="form_item_upload" for="avatar"><?php echo "Browse"?></label>
								<input type="file" id="avatar" name="add_avatar" accept="image/*"/>
							</div>
						</div>
					</div>
				</div>
				<div class="form_error">
					<?php
						if (isset($errors["description"])) {
							echo '<span class="error">' . $errors["description"] . '</span><br>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Mô tả chi tiết"?></label>
					</div>
					<textarea class="form_item_textarea" name="add_description" placeholder="Nhập mô tả chi tiết" maxlength="1000"><?php if (isset($description) && !isset($errors["duplicate"])) { echo $description; }?></textarea>
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
	$('#avatar').change(function() {
		var i = $(this).prev('label').clone();
		var file = $('#avatar')[0].files[0].name;
		document.getElementById("filename").innerHTML = file;
		document.getElementById("add_avatar").src = window.URL.createObjectURL(this.files[0]);
	});
</script>
</html>