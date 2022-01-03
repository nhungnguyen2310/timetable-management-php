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
			<div class="title"><?php echo "YÊU CẦU ĐẶT LẠI MẬT KHẨU THÀNH CÔNG"?></div>
			<div class="confirm">
				<p>Bạn đã gửi thành công yêu cầu đặt lại mật khẩu cho người dùng <span style="color: blue"><?php echo $username?></span>.</p>
			</div>
			<div>
				<input class="button" type="submit" name="home" value="Trở về trang chủ">
			</div>
		</form>
	</div>
</body>