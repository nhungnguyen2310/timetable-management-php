<?php
	function request_reset($username) {
		global $db;
		$microtime = microtime(true);
		$query = "UPDATE admins SET reset_password_token = '$microtime' WHERE login_id = '$username'";
		$statement = $db->prepare($query);
		$statement->execute();
	}
?>