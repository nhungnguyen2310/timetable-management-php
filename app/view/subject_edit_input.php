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
				<span><?php echo "CHỈNH SỬA THÔNG TIN MÔN HỌC"?></span>
			</div>
			<div class="form_error_">
				<?php
					if (isset($errors["duplicate"])) {
						echo '<span class="error">' . $errors["duplicate"] . '</span>';
					}
				?>
			</div>
			<div class="form">
				<div class="form_error_">
					<?php
						if (isset($errors["name"])) {
							echo '<span class="error">' . $errors["name"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Tên môn học"?></label>
					</div>
					<input class="form_item_input" name="new_name" placeholder="Nhập tên môn học" maxlength="100" value="<?php echo $name?>">
				</div>
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
					<select class="select_box" name="new_school_year">
						<?php
							$years = array("--Chọn năm học--", "Năm 1", "Năm 2", "Năm 3", "Năm 4");
							$year = substr($school_year, 4);
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
						if (isset($errors["description"])) {
							echo '<span class="error">' . $errors["description"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Mô tả chi tiết"?></label>
					</div>
					<textarea class="form_item_textarea" name="new_description" placeholder="Nhập mô tả chi tiết" maxlength="1000"><?php echo $description?></textarea>
				</div>
				<div class="form_error">
					<?php
						if (isset($errors["avatar"])) {
							echo '<span class="error">' . $errors["avatar"] . '</span>';
						}
					?>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Ảnh đại diện"?></label>
					</div>
					<div class="form_item_image">
						<div class="form_item_avatar">
							<img id="new_avatar" src="<?php echo '../../web/avatar/subject/' . $avatar?>">
						</div>
						<div class="form_item_file" id="browse">
							<div class="form_item_filename" id="filename"></div>
							<div class="form_item_button">
								<label class="form_item_upload" for="avatar"><?php echo "Browse"?></label>
								<input type="file" id="avatar" name="new_avatar" accept="image/*"/>
							</div>
						</div>
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
	$('#avatar').change(function() {
		var i = $(this).prev('label').clone();
		var file = $('#avatar')[0].files[0].name;
		document.getElementById("filename").innerHTML = file;
		document.getElementById("new_avatar").src = window.URL.createObjectURL(this.files[0]);
		console.log(window.URL.createObjectURL(this.files[0]));
	});
</script>
</html>