<?php
	function getSchedules($school_year="", $subject="", $teacher="") {
		global $db;
		$query = "SELECT schedules.id, schedules.teacher_id, schedules.weekday, schedules.lesson, schedules.notes FROM schedules INNER JOIN teachers ON schedules.teacher_id = teachers.id INNER JOIN subjects ON teachers.subject_id = subjects.id";
		if (!empty($school_year)) {
			$query .= " WHERE subjects.school_year = '$school_year'";
		}
		if (!empty($subject)) {
			if (str_contains($query, "WHERE")) {
				$query .= " AND ";
			} else {
				$query .= " WHERE ";
			}
			$query .= "subjects.name = '$subject'";
		}
		if (!empty($teacher)) {
			if (str_contains($query, "WHERE")) {
				$query .= " AND ";
			} else {
				$query .= " WHERE ";
			}
			$query .= "teachers.name = '$teacher'";
		}
		$query .= " ORDER BY schedules.id DESC";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array($count, $results);
	}

	function deleteSchedule($schedule_id) {
		global $db;
		$query = "DELETE FROM schedules WHERE id = '$schedule_id'";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function editSchedule($schedule_id, $teacher_id, $weekday, $lesson, $notes) {
		global $db;
		$query = "UPDATE schedules SET teacher_id = '$teacher_id', weekday = '$weekday', lesson = '$lesson', notes = '$notes', updated = current_timestamp() WHERE id = '$schedule_id'";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function addSchedule($teacher_id, $weekday, $lesson, $notes) {
		global $db;
		$query = "INSERT INTO schedules (teacher_id, weekday, lesson, notes) VALUES ('$teacher_id', '$weekday', '$lesson', '$notes')";
		$statement = $db->prepare($query);
		$statement->execute();
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

	function getTeacherName($teacher_id) {
		global $db;
		$query = "SELECT name FROM teachers WHERE id = '$teacher_id'";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = "";
		foreach ($statement as $row) {
			$result = $row["name"];
		}
		return $result;
	}

	function getSubjectID($subject_name, $school_year) {
		global $db;
		$query = "SELECT id FROM subjects WHERE name = '$subject_name' AND school_year = '$school_year'";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = "";
		foreach ($statement as $row) {
			$result = $row["id"];
		}
		return $result;
	}

	function getSubjectID_($teacher_id) {
		global $db;
		$query = "SELECT subject_id FROM teachers WHERE id = '$teacher_id'";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = "";
		foreach ($statement as $row) {
			$result = $row["subject_id"];
		}
		return $result;
	}

	function getTeacherID($teacher_name) {
		global $db;
		$query = "SELECT id FROM teachers WHERE name = '$teacher_name'";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = "";
		foreach ($statement as $row) {
			$result = $row["id"];
		}
		return $result;
	}

	function getSchoolYear($subject_id) {
		global $db;
		$query = "SELECT school_year FROM subjects WHERE id = '$subject_id'";
		$statement = $db->prepare($query);
		$statement->execute();
		$result = "";
		foreach ($statement as $row) {
			$result = $row["school_year"];
		}
		return $result;
	}

	function getSubjects($school_year="") {
		global $db;
		$query = "SELECT * FROM subjects ORDER BY name";
		if (!empty($school_year)) {
			$query = "SELECT * FROM subjects WHERE school_year = '$school_year' ORDER BY name";
		}
		$statement = $db->prepare($query);
		$statement->execute();
		$subjects = array("--Chọn môn học--");
		foreach ($statement as $row) {
			array_push($subjects, $row["name"]);
		}
		return $subjects;
	}

	function getTeachers($subject_id="") {
		global $db;
		$query = "SELECT * FROM teachers ORDER BY name";
		if (!empty($subject_id)) {
			$query = "SELECT teachers.name FROM teachers JOIN (SELECT * FROM subjects WHERE id = '$subject_id') as subjects_ ON teachers.subject_id = subjects_.id ORDER BY teachers.name";
		}
		$statement = $db->prepare($query);
		$statement->execute();
		$teachers = array("--Chọn giáo viên--");
		foreach ($statement as $row) {
			array_push($teachers, $row["name"]);
		}
		return $teachers;
	}

	function getIndex($string, $array) {
		$index = -1;
		for ($i = 0; $i < count($array); $i++) {
			if ($string == $array[$i]) {
				$index = $i;
			}
		}
		return $index;
	}

	function check($teacher_id, $weekday, $lesson, $notes) {
		global $db;
		$query = "SELECT * FROM schedules WHERE teacher_id = '$teacher_id' AND weekday = '$weekday' AND lesson = '$lesson' AND notes = '$notes'";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		if ($count > 0) {
			return true;
		}
		return false;
	}
?>