<?php
	function getTeachers() {
		global $db;
		$query = "SELECT * FROM teachers ORDER BY name";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$teachers = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array($count, $teachers);
	}

	function search($keyword, $subject="") {
		global $db;
		if (empty($keyword)) {
			$keyword = "%%";
		}
		if (empty($subject_id)) {
			$subject_id = "%%";
		}
		$query = "SELECT teachers.id, teachers.name, teachers.avatar, teachers.description, teachers.subject_id, teachers.degree FROM teachers INNER JOIN subjects ON teachers.subject_id = subjects.id WHERE subjects.name LIKE '%$subject%' AND (teachers.degree LIKE '%$keyword%' OR subjects.name LIKE '%$keyword%' OR teachers.name LIKE '%$keyword%' OR teachers.description LIKE '%$keyword%') ORDER BY teachers.name";
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
			unlink("../../web/avatar/" . $teacher["avatar"]);
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

	function saveAvatar($file, $name, $new_name) {
		global $db;
		$tempname = $_FILES[$file]["tmp_name"];
		$new_path = "../../web/avatar/" . $new_name;
		$old_path = "../../web/avatar/" . $name;
		if (file_exists($old_path) && $name != "temp.jpg") {
			unlink($old_path);
		}
		move_uploaded_file($tempname, $new_path);
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