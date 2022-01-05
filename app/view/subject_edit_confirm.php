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
</head>

<body>
	<div class="container">
		<form action="" method="POST">
			<div class="form_title">
				<span><?php echo "XÁC NHẬN THAY ĐỔI THÔNG TIN MÔN HỌC"?></span>
			</div>
			<div class="form">
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Tên môn học"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo $name?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Năm học"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo $school_year?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Mô tả chi tiết"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo $description?></span>
					</div>
				</div>
			</div>
			<div class="buttons">
				<input class="button" name="back_edit" type="submit" value="Sửa lại">
				<input class="button" name="edit_confirm" type="submit" value="Xác nhận">
			</div>
		</form>
	</div>
</body>
</html>