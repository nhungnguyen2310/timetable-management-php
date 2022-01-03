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
				<span><?php echo "XÁC NHẬN XÓA THÔNG TIN LỚP HỌC"?></span>
			</div>
			<div class="form">
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Khóa"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo getSchoolYear(getSubjectID_($schedule['teacher_id']))?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Môn học"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo getSubjectName(getSubjectID_($schedule['teacher_id']))?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Giáo viên"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo getTeacherName($schedule['teacher_id'])?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Thứ"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo $schedule['weekday']?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Tiết"?></label>
					</div>
					<div class="form_item_table">
						<span><?php echo $schedule["lesson"]?></span>
					</div>
				</div>
				<div class="form_item">
					<div class="form_item_title">
						<label class="label"><?php echo "Ghi chú"?></label>
					</div>
					<div class="form_item_information">
						<span><?php echo $schedule['notes']?></span>
					</div>
				</div>
			</div>
			<div class="buttons">
				<input class="button" name="back" type="submit" value="Quay lại">
				<input class="button" name="delete_confirm" type="submit" value="Xác nhận">
			</div>
		</form>
	</div>
</body>
</html>