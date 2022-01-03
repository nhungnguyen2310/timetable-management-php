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
			<div class="form_title">
				<span><?php echo "YÊU CẦU ĐẶT LẠI MẬT KHẨU"?></span>
			</div>
			<div class="form_error">
				<?php
					if (strlen($error) > 0) {
						echo '<span class="error">' . $error . '</span><br>';
					}
				?>
			</div>
			<div class="form">
				<div class="form_label">
					<label class="label"><?php echo "Tên đăng nhập"?></label>
				</div>
				<input type="text" name="reset_username" class="form_input" maxlength='10' placeholder="Tên đăng nhập" id="username">
			</div>
			<div class="buttons">
				<input class="button" type="submit" name="back" value="Trở về">
				<input class="button" type="submit" name="reset_request" value="Gửi yêu cầu đặt lại mật khẩu">
			</div>
		</form>
	</div>
</body>