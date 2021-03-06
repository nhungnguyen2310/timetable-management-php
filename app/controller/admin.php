<?php
	session_start();
	require_once '../common/db.php';
	require_once '../common/functions.php';

	if ($_SESSION['authen'] == false) {
		redirect("../../login.php");
	}

	require_once '../model/admin_model.php';

	if (isset($_POST["logout"])) {
		$_SESSION['authen'] = false;
		unset($_SESSION['currentuser']);
		redirect("../../login.php");
	}

	$error = "";
	$data = getUsers();
	$count = $data[0];
	$users = $data[1];

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		for ($i = 0; $i < $count; $i++) {
			if (isset($_POST["reset_password_" . $i . ""])) {
				if (empty($_POST["new_password_" . $i . ""])) {
					$error = "Hãy nhập mật khẩu mới!";
					include '../view/admin.php';
				} else {
					$password = format($_POST["new_password_" . $i . ""]);
					if (strlen($password) < 6) {
						$error = "Hãy nhập mật khẩu mới có ít nhất 6 ký tự!";
						include '../view/admin.php';
					} else {
						$user = $users[$i];
						$username = $user['login_id'];
						resetPassword($username, $password);
						header("Refresh:0");
					}
				}
			}
		}
	} else {
		include '../view/admin.php';
	}
?>