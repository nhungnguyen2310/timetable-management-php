<?php
	session_start();
	require_once '../common/db.php';
	require_once '../common/functions.php';

	$error = "";

	include '../model/resetpassword_model.php';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["reset_request"])) {
			if (empty($_POST["reset_username"])) {
				$error = "Hãy nhập tên tài khoản!";
				include "../view/resetpassword_input.php";
				$error = "";
			} else {
				$username = $_POST["reset_username"];
				$_SESSION["username"] = $username;
				$query = "SELECT * FROM admins WHERE login_id = '$username'";
				$statement = $db->prepare($query);
				$statement->execute();
				$count = $statement->rowCount();
				if ($count > 0) {
					request_reset($username);
					$username = $_SESSION["username"];
					include_once "../view/resetpassword_complete.php";
				} else {
					$error = "Tên tài khoản không tồn tại!";
					include "../view/resetpassword_input.php";
					$error = "";
				}
			}
		} elseif (isset($_POST["home"]) || isset($_POST["back"])) {
			unset($_SESSION["username"]);
			redirect("../../login.php");
		}
	} else {
		include "../view/resetpassword_input.php";
	}
?>

