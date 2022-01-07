<?php
	function getSubjects($school_year="", $keyword="") {
		global $db;
		$query = "SELECT * FROM subjects";
		if (!empty($school_year)) {
			$query .= " WHERE school_year = '$school_year'";
		}
		if (!empty($keyword)) {
			if (str_contains($query, "WHERE")) {
				$query .= " AND ";
			} else {
				$query .= " WHERE ";
			}
			$query .= "(name LIKE '%$keyword%' OR description LIKE '%$keyword%')";
		}
		$query .= " ORDER BY id DESC";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array($count, $results);
	}

	function deleteSubject($subject_id) {
		global $db;
		$query2 = "SELECT * FROM teachers WHERE subject_id = '$subject_id'";
		$statement2 = $db->prepare($query2);
		$statement2->execute();
		$count2 = $statement2->rowCount();
		if ($count2 > 0) {
			foreach ($statement2 as $teacher) {
				if ($teacher["avatar"] != "temp.jpg") {
					unlink("../../web/avatar/" . $teacher["avatar"]);
				}
			}
		}
		$query2 = "SELECT * FROM subjects WHERE id = '$subject_id'";
		$statement2 = $db->prepare($query2);
		$statement2->execute();
		foreach ($statement2 as $subject) {
			if ($subject["avatar"] != "temp.jpg") {
				unlink("../../web/avatar/subject/" . $subject["avatar"]);
			}
		}
		$query = "DELETE FROM subjects WHERE id = '$subject_id'";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function editSubject($subject_id, $avatar, $name, $description, $school_year) {
		global $db;
		$query = "UPDATE subjects SET avatar = '$avatar', name = '$name', description = '$description', school_year = '$school_year', updated = current_timestamp() WHERE id = '$subject_id'";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function addSubject($name, $avatar, $description, $school_year) {
		global $db;
		$query = "INSERT INTO subjects (name, avatar, description, school_year) VALUES ('$name', '$avatar', '$description', '$school_year')";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function saveTempAvatar($file, $new_name) {
		global $db;
		$tempname = $_FILES[$file]["tmp_name"];
		$tmp_path = "../../web/avatar/tmp/" . $new_name;
		move_uploaded_file($tempname, $tmp_path);
	}

	function saveAvatar($old, $new) {
		global $db;
		$old_path = "../../web/avatar/subject/" . $old;
		$tmp_path = "../../web/avatar/tmp/" . $new;
		$new_path = "../../web/avatar/subject/" . $new;
		if (file_exists($old_path) && $old != "temp.jpg") {
			unlink($old_path);
		}
		rename($tmp_path, $new_path);
	}

	function check($name, $school_year, $description) {
		global $db;
		$query = "SELECT * FROM subjects WHERE name = '$name' AND school_year = '$school_year' AND description = '$description'";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		if ($count > 0) {
			return true;
		}
		return false;
	}
?>