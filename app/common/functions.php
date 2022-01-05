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

	function clean() {
		$files = glob('../../web/avatar/tmp/{,.}*', GLOB_BRACE);
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file);
			}
		}
	}

	function format($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}
?>