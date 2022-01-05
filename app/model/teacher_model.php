<?php
	function getTeachers($subject="", $keyword="") {
		global $db;
		$query = "SELECT teachers.id, teachers.name, teachers.avatar, teachers.description, teachers.subject_id, teachers.degree FROM teachers INNER JOIN subjects ON teachers.subject_id = subjects.id";
		if (!empty($subject)) {
			$query .= " WHERE subjects.name = '$subject'";
		}
		if (!empty($keyword)) {
			if (str_contains($query, "WHERE")) {
				$query .= " AND ";
			} else {
				$query .= " WHERE ";
			}
			$query .= "(teachers.degree LIKE '%$keyword%' OR teachers.name LIKE '%$keyword%' OR teachers.description LIKE '%$keyword%')";
		}
		$query .= " ORDER BY id DESC";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array($count, $results);
	}

	function deleteTeacher($teacher_id) {
		global $db;
		$query2 = "SELECT * FROM teachers WHERE id = '$teacher_id'";
		$statement2 = $db->prepare($query2);
		$statement2->execute();
		foreach ($statement2 as $teacher) {
			if ($teacher["avatar"] != "temp.jpg") {
				unlink("../../web/avatar/" . $teacher["avatar"]);
			}
		}
		$query = "DELETE FROM teachers WHERE id = '$teacher_id'";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function editTeacher($teacher_id, $name, $avatar, $description, $subject_id, $degree) {
		global $db;
		$query = "UPDATE teachers SET name = '$name', avatar = '$avatar', description = '$description', subject_id = '$subject_id', degree = '$degree', updated = current_timestamp() WHERE id = '$teacher_id'";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function addTeacher($name, $avatar, $description, $subject_id, $degree) {
		global $db;
		$query = "INSERT INTO teachers (name, avatar, description, subject_id, degree) VALUES ('$name', '$avatar', '$description', '$subject_id', '$degree')";
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
		$old_path = "../../web/avatar/" . $old;
		$tmp_path = "../../web/avatar/tmp/" . $new;
		$new_path = "../../web/avatar/" . $new;
		if (file_exists($old_path) && $old != "temp.jpg") {
			unlink($old_path);
		}
		rename($tmp_path, $new_path);
	}

	function getSubjectName($subject_id) {
		global $db;
		$query = "SELECT name FROM subjects WHERE id = '$subject_id'";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = "";
		foreach ($statement as $row) {
			$result = $row["name"];
		}
		return $result;
	}

	function getSubjectID($subject_name) {
		global $db;
		$query = "SELECT id FROM subjects WHERE name = '$subject_name'";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = "";
		foreach ($statement as $row) {
			$result = $row["id"];
		}
		return $result;
	}

	function getSubjects() {
		global $db;
		$query = "SELECT * FROM subjects ORDER BY name";
		$statement = $db->prepare($query);
		$statement->execute();
		$subjects = array("--Chọn chuyên ngành--");
		foreach ($statement as $row) {
			array_push($subjects, $row["name"]);
		}
		return $subjects;
	}

	function check($name, $description, $subject_id, $degree) {
		global $db;
		$query = "SELECT * FROM teachers WHERE name = '$name' AND description = '$description' AND subject_id = '$subject_id' AND degree = '$degree'";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		if ($count > 0) {
			return true;
		}
		return false;
	}
?>