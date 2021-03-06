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
				<span><?php echo "XÁC NHẬN THÊM THÔNG TIN GIÁO VIÊN"?></span>
			</div>
			<div class="form">
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Tên giáo viên"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo $name?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Chuyên ngành"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo getSubjectName($subject_id)?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Học vị"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo $degree?></span>
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
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Ảnh đại diện"?></label>
					</div>
					<div class="form_item_avatar">
						<img src="<?php echo '../../web/avatar/tmp/' . $avatar . ''?>">
					</div>
				</div>
			</div>
			<div class="buttons">
				<input class="button" name="back_add" type="submit" value="Sửa lại">
				<input class="button" name="add_confirm" type="submit" value="Xác nhận">
			</div>
		</form>
	</div>
</body>
</html>