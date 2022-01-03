<?php
	const serverName = 'localhost';
	const username = 'root';
	const password = '';
	const database = 'timetable';
	const driver = 'mysql';

	try {
		if (class_exists('PDO')) {
			$dsn = driver . ':dbname=' . database . ';host=' . serverName;

			$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			$db = new PDO($dsn, username, password, $options);
		}
	} catch (Exception $e) {
		echo $e->getMessage() . '<br>';
		die();
	}
?>