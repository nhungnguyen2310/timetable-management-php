<?php
	function getUsers() {
		global $db;
		$query = "SELECT * FROM admins WHERE reset_password_token IS NOT NULL ORDER BY reset_password_token";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$users = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array($count, $users);
	}

	function resetPassword($username, $password) {
		global $db;
		$encrypted_password = md5($password);
		$query = "UPDATE admins SET password = '$encrypted_password', reset_password_token = NULL WHERE login_id = '$username'";
		$statement = $db->prepare($query);
		$statement->execute();
	}
?>