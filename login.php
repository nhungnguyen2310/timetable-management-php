<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<style type="text/css">
		<?php include 'web/css/login.css'; ?>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap');
	</style>
</head>

<?php
	session_start();
	require_once 'app/common/db.php';
	require_once 'app/common/functions.php';
	date_default_timezone_set("Asia/Bangkok");

	$_SESSION['authen'] = false;
	$errors = array();
	$data = array();
	$username = "";
	$password = "";
	$encrypted_password = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["username"])) {
			$errors["username"] = "Hãy nhập tài khoản!";
		} else {
			if (strlen($_POST["username"]) < 4) {
				$errors["username"] = "Hãy nhập tài khoản có tối thiểu 4 ký tự!";
			} else {
				$username = format($_POST["username"]);
			}
		}

		if (empty($_POST["password"])) {
			$errors["password"] = "Hãy nhập mật khẩu!";
		} else {
			if (strlen($_POST["password"]) < 6) {
				$errors["password"] = "Hãy nhập mật khẩu có tối thiểu 6 ký tự!";
			} else {
				$password = format($_POST["password"]);
				$encrypted_password = md5($password);
			}
		}

		if (count($errors) == 0) {
			$query = "SELECT * FROM admins WHERE login_id = '$username' AND password = '$encrypted_password'";
			$statement = $db->prepare($query);
			$statement->execute();
			$count = $statement->rowCount();
			if ($count > 0) {
				$_SESSION['authen'] = true;
				$_SESSION['currentuser'] = $username;
				$_SESSION['date_login'] = date('Y-m-d H:i');
				if ($username == "admin") {
					redirect("app/controller/admin.php");
				} else {
					redirect("home.php");
				}
			} else {
				$errors["login"] = "Tên đăng nhập hoặc mật khẩu sai!";
				$_SESSION['authen'] = false;
			}
		}
	}
?>

<body>
	<div class="container">
		<form action="" method="POST">
			<div class="form_error">
				<?php
					foreach ($errors as $key => $value) {
						echo '<span class="error">' . $value . '</span>';
						echo '<br>';
					}
				?>
			</div>

			<div class="form">
				<div class="form_label">
					<label class="label" for="username"><?php echo "Tên đăng nhập" ?></label>
				</div>
				<input type="text" name="username" class="form_input" maxlength='10' placeholder="Tên đăng nhập" id="username" value="<?php echo $username; ?>">
			</div>

			<div class="form">
				<div class="form_label">
					<label class="label" for="password]"><?php echo "Mật khẩu" ?></label>
				</div>
				<input type="password" name="password" class="form_input" maxlength='64' placeholder="Mật khẩu" id="password" value="<?php if (!empty($password)) echo $password; ?>">
			</div>

			<div class="reset">
				<a href="app/controller/resetpassword.php">Quên mật khẩu</a>
			</div>

			<div>
				<input class="button" type="submit" value="Đăng nhập">
			</div>
		</form>
	</div>
</body>
</html>