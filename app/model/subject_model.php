<?php
	function getSubjects() {
		global $db;
		$query = "SELECT * FROM subjects ORDER BY school_year";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		$subjects = $statement->fetchAll(PDO::FETCH_ASSOC);
		return array($count, $subjects);
	}

	function search($keyword, $school_year="") {
		global $db;
		if (empty($keyword)) {
			$keyword = "%%";
		}
		if (empty($school_year)) {
			$school_year = "%%";
		}
		$query = "SELECT * FROM subjects WHERE (name LIKE '%$keyword%' OR description LIKE '%$keyword%' OR school_year LIKE '%$keyword%') AND school_year LIKE '%$school_year%' ORDER BY school_year";
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
				unlink("../../web/avatar/" . $teacher["avatar"] . "");
			}
		}
		$query = "DELETE FROM subjects WHERE id = '$subject_id'";
		$statement = $db->prepare($query);
		$statement->execute();
		
	}

	function editSubject($subject_id, $name, $description, $school_year) {
		global $db;
		$query = "UPDATE subjects SET name = '$name', description = '$description', school_year = '$school_year', updated = current_timestamp() WHERE id = '$subject_id'";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function addSubject($name, $description, $school_year) {
		global $db;
		$query = "INSERT INTO subjects (name, description, school_year) VALUES ('$name', '$description', '$school_year')";
		$statement = $db->prepare($query);
		$statement->execute();
	}

	function check($name, $school_year) {
		global $db;
		$query = "SELECT * FROM subjects WHERE name = '$name' AND school_year = '$school_year'";
		$statement = $db->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();
		if ($count > 0) {
			return true;
		}
		return false;
	}
?>