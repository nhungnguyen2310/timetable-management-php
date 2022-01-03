<?php
	function redirect($path) {
		header('Location: ' . $path);
		exit;
	}

	function alert($message) {
		echo "<script>alert('$message');</script>";
	}

	function console_log($value) {
		echo "<script>console.log('" . $value . "');</script>";
	}
?>