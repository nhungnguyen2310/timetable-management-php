<?php
	session_start();
	require_once '../common/db.php';
	require_once '../common/functions.php';

	if ($_SESSION['authen'] == false) {
		redirect("../../login.php");
	}

	if (isset($_POST["logout"])) {
		$_SESSION['authen'] = false;
		unset($_SESSION['currentuser']);
		redirect("../../login.php");
	}

	require_once '../model/subject_model.php';

	$data = getSubjects();
	$count = $data[0];
	$subjects = $data[1];

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["back"])) {
			if (isset($_SESSION['add_subject'])) {
				unset($_SESSION['add_subject']);
			}
			clean();
			include '../view/subject_search.php';
		} elseif (isset($_POST["home"])) {
			if (isset($_SESSION['add_subject'])) {
				unset($_SESSION['add_subject']);
			}
			clean();
			redirect("../../home.php");
		} elseif (isset($_POST["back_edit"])) {
			$subject = $_SESSION['subject_edited'];
			$name = $subject["name"];
			$description = $subject["description"];
			$school_year = $subject["school_year"];
			include '../view/subject_edit_input.php';
		} elseif (isset($_POST["edit_submit"])) {
			$errors = array();
			if (empty($_POST["new_name"])) {
				$name = "";
				$errors["name"] = "Hãy nhập tên!";
			} else {
				$name = format($_POST["new_name"]);
			}
			if ($_POST["new_school_year"] == 0) {
				$errors["school_year"] = "Hãy chọn năm học!";
				$school_year = "";
			} else {
				$school_year = "Năm " . $_POST["new_school_year"];
			}
			if (empty($_POST["new_description"])) {
				$errors["description"] = "Hãy nhập mô tả chi tiết!";
				$description = "";
			} else {
				$description = format($_POST["new_description"]);
			}
			if (check($name, $school_year, $description)) {
				$errors["duplicate"] = "Môn học đã tồn tại!";
			}
			if (count($errors) > 0) {
				include '../view/subject_edit_input.php';
			} else {
				$_SESSION['subject_edited'] = array("name" => $name, "description" => $description, "school_year" => $school_year);
				include '../view/subject_edit_confirm.php';
			}
		} elseif (isset($_POST["edit_confirm"])) {
			$subject = $_SESSION['subject_editing'];
			$edited = $_SESSION['subject_edited'];
			editSubject($subject["id"], $edited["name"], $edited["description"], $edited["school_year"]);
			include_once '../view/subject_edit_complete.php';
			unset($_SESSION['subject_editing']);
			unset($_SESSION['subject_edited']);
		} elseif (isset($_POST["back_add"])) {
			$subject = $_SESSION['subject_adding'];
			$name = $subject["name"];
			$description = $subject["description"];
			$school_year = $subject["school_year"];
			include '../view/subject_edit_input.php';
		} elseif (isset($_POST['add_submit'])) {
			$errors = array();
			if (empty($_POST["add_name"])) {
				$errors["name"] = "Hãy nhập tên môn học!";
			} else {
				$name = format($_POST["add_name"]);
			}
			if ($_POST["add_school_year"] == 0) {
				$errors["year"] = "Hãy chọn năm học!";
			} else {
				$school_year = "Năm " . $_POST["add_school_year"];
			}
			if (empty($_POST["add_description"])) {
				$errors["description"] = "Hãy nhập mô tả chi tiết!";
			} else {
				$description = format($_POST["add_description"]);
			}
			if (isset($name, $school_year, $description)) {
				if (check($name, $school_year, $description)) {
					$errors["duplicate"] = "Môn học đã tồn tại!";
				}
			}
			if (count($errors) > 0) {
				include '../view/subject_add_input.php';
			} else {
				$_SESSION['subject_adding'] = array("name" => $name, "description" => $description, "school_year" => $school_year);
				include '../view/subject_add_confirm.php';
				unset($_SESSION['add_subject']);
			}
		} elseif (isset($_POST['add_confirm'])) {
			$subject = $_SESSION['subject_adding'];
			addSubject($subject[0], $subject[1], $subject[2]);
			include '../view/subject_add_complete.php';
			unset($_SESSION['subject_adding']);
		} else {
			for ($i = 0; $i < $count; $i++) {
				$subject = $subjects[$i];
				if (isset($_POST["delete_" . $i . ""])) {
					deleteSubject($subject["id"]);
					header("Refresh:0");
				} elseif (isset($_POST["edit_" . $i . ""])) {
					$_SESSION['subject_editing'] = $subject;
					$name = $subject["name"];
					$school_year = $subject["school_year"];
					$description = $subject["description"];
					include "../view/subject_edit_input.php";
				}
			}
		}
	} elseif (isset($_SESSION['add_subject'])) {
		include '../view/subject_add_input.php';
	} else {
		include '../view/subject_search.php';
	}
?>

