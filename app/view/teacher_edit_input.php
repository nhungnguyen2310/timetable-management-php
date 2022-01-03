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
				<span><?php echo "CHỈNH SỬA THÔNG TIN GIÁO VIÊN"?></span>
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
						<label class="label"><?php echo "Tên giáo viên"?></label>
					</div>
					<input class="form_item_input" name="new_name" placeholder="Nhập tên giáo viên" maxlength="250" value="<?php echo $teacher['name']?>">
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Chuyên ngành"?></label>
					</div>
					<select class="select_box form_item_input" name="new_subject_id">
						<?php
							$subject = getSubjectName($teacher['subject_id']);
							$chose = "";
							foreach ($subjects as $key => $value) {
								if (isset($subject) && ($subject == $key || $subject == $value)) {
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
						<label class="label"><?php echo "Học vị"?></label>
					</div>
					<input class="form_item_input" name="new_degree" placeholder="Nhập học vị" maxlength="10" value="<?php echo $teacher['degree']?>">
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Mô tả chi tiết"?></label>
					</div>
					<input class="form_item_input" name="new_description" placeholder="Nhập mô tả chi tiết" value="<?php if (!empty($teacher['description'])) { echo $teacher['description']; }?>">
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Ảnh đại diện"?></label>
					</div>
					<div class="form_item_image">
						<div class="form_item_avatar">
							<img id="new_avatar" src="<?php echo '../../web/avatar/' . $teacher['avatar']?>">
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