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
	$data = getUser();
	$count = $data[0];
	$users = $data[1];

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		for ($i = 0; $i < $count; $i++) {
			if (isset($_POST["reset_password_" . $i . ""])) {
				if (empty($_POST["new_password_" . $i . ""])) {
					$error = "Hãy nhập mật khẩu mới!";
					alert($error);
					header("Refresh:0");
				} else {
					$password = $_POST["new_password_" . $i . ""];
					if (strlen($password) < 6) {
						$error = "Hãy nhập mật khẩu mới có ít nhất 6 ký tự!";
						alert($error);
						header("Refresh:0");
					} else {
						$user = $users[$i];
						$username = $user['login_id'];
						resetPassword($username, $password);
						$alert = "Thay đổi mật khẩu cho người dùng " . $username . " thành công!";
						alert($alert);
						header("Refresh:0");
					}
				}
			}
		}
	} else {
		include_once '../view/admin.php';
	}
?>