<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TTB</title>
	<style type="text/css">
		<?php include '../../web/css/login.css'; ?>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap');
	</style>
</head>

<body>
	<div class="container">
		<form action="" method="POST">
			<div class="title"><?php echo "XÁC NHẬN YÊU CẦU ĐẶT LẠI MẬT KHẨU"?></div>
			<div class="form">
				<div class="form_label">
					<label class="label"><?php echo "Tên đăng nhập"?></label>
				</div>
				<div class="form_input_confirm"><?php echo $username?></div>
			</div>
			<div class="buttons">
				<input class="button" type="submit" name="back" value="Trở về">
				<input class="button" type="submit" name="reset_confirm" value="Xác nhận">
			</div>
		</form>
	</div>
</body>