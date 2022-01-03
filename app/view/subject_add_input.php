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
				<span><?php echo "THÊM THÔNG TIN MÔN HỌC"?></span>
			</div>
			<div class="form_error">
				<?php
					if (isset($errors)) {
						foreach ($errors as $key => $value) {
							echo '<span class="error">' . $value . '</span>';
							echo '<br>';
						}
					}
				?>
			</div>
			<div class="form">
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Tên môn học"?></label>
					</div>
					<input class="form_item_input" name="add_name" placeholder="Nhập tên môn học" value="<?php if (isset($name) && !isset($errors["duplicate"])) { echo $name; }?>">
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Khóa"?></label>
					</div>
					<select class="select_box" name="add_school_year">
						<?php
							$years = array("--Chọn năm học--", "Năm 1", "Năm 2", "Năm 3", "Năm 4");
							$chose = "";
							foreach ($years as $key => $value) {
								if (isset($year) && ($year == $key) && !isset($errors["duplicate"])) {
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
						<label class="label"><?php echo "Mô tả chi tiết"?></label>
					</div>
					<input class="form_item_input" name="add_description" placeholder="Nhập mô tả chi tiết" value="<?php if (isset($description) && !isset($errors["duplicate"])) { echo $description; }?>">
				</div>
			</div>
			<div class="buttons">
				<input class="button" name="home" type="submit" value="Quay lại">
				<input class="button" name="add_submit" type="submit" value="Xác nhận">
			</div>
		</form>
	</div>
</body>
</html>