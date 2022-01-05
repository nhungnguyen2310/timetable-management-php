<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TTB</title>
	<style type="text/css">
		<?php include '../../web/css/admin.css'; ?>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap');
	</style>
</head>

<body>
	<div class="container">
		<form action="" method="POST">
			<div class="logout">
				<input class="button_logout" name="logout" type="submit" value="Đăng xuất">
			</div>
			<div class="user_table">
				<table>
					<tr>
						<th class="no"><?php echo "No."?></th>
						<th class="name"><?php echo "Tên người dùng"?></th>
						<th class="pass"><?php echo "Mật khẩu mới"?></th>
						<th class="btn"><?php echo "Action"?></th>
					</tr>
					<?php
						for ($i = 0; $i < $count; $i++) {
							$user = $users[$i];
							$_SESSION["username"] = $user['login_id'];
							echo "<tr>";
							echo "<td class='no'>" . $i+1 . "</td>";
							echo "<td class='name'>" . $user['login_id'] . "</td>";
							echo "<td class='pass'>";
							if (!empty($error)) {
								echo "<div style='color: red' id='span'>" . $error . "</div>";
							}
							echo "<input type='password' name='new_password_" . $i . "' class='input' maxlength='64' placeholder='Mật khẩu mới' id='password'>";
							echo "</td>";
							echo "<td class='btn'><div><input class='button_reset' name='reset_password_" . $i . "' type='submit' value='Reset'></div></td>";
							echo "</tr>";
						}
					?>
					<tr>
						<td class="no">&nbsp;</td>
						<td class="name">&nbsp;</td>
						<td class='pass'>&nbsp;</td>
						<td class='btn'>&nbsp;</td>
					</tr>
				</table>
			</div>
		</form>
	</div>
</body>
</html>