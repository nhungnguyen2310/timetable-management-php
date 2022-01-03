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
		if (isset($_POST["search"])) {
			$keyword = $_POST['keyword'];
			if ($_POST['school_year'] != 0) {
				$school_year = "Năm " . $_POST['school_year'] . "";
				$data = search($keyword, $school_year);
			} else {
				$data = search($keyword);
			}
			$count = $data[0];
			$subjects = $data[1];
			include_once '../view/subject_search.php';
		} elseif (isset($_POST["back"])) {
			if (isset($_SESSION['add_subject'])) {
				unset($_SESSION['add_subject']);
			}
			include_once '../view/subject_search.php';
		} elseif (isset($_POST["home"])) {
			if (isset($_SESSION['add_subject'])) {
				unset($_SESSION['add_subject']);
			}
			redirect("../../home.php");
		} elseif (isset($_POST["delete_confirm"])) {
			$subject = $_SESSION['subject_deleting'];
			$id = $subject['id'];
			deleteSubject($id);
			include_once '../view/subject_delete_complete.php';
			unset($_SESSION['subject_deleting']);
		} elseif (isset($_POST["edit_submit"])) {
			$error = "";
			$subject = $_SESSION['subject_editing'];
			if (empty($_POST["new_name"])) {
				$new_name = $subject["name"];
			} else {
				$new_name = $_POST["new_name"];
			}
			if ($_POST["new_school_year"] == 0) {
				$new_school_year = $subject["school_year"];
			} else {
				$new_school_year = "Năm " . $_POST["new_school_year"];
			}
			if (check($new_name, $new_school_year)) {
				$error = "Môn học đã tồn tại!";
			}
			if (!empty($error)) {
				$subject = $_SESSION['subject_editing'];
				include '../view/subject_edit_input.php';
			} else {
				$new_description = $_POST["new_description"];
				$_SESSION['subject_edited'] = array($new_name, $new_description, $new_school_year);
				include_once '../view/subject_edit_confirm.php';
			}
		} elseif (isset($_POST["edit_confirm"])) {
			$subject = $_SESSION['subject_editing'];
			$new = $_SESSION['subject_edited'];
			editSubject($subject["id"], $new[0], $new[1], $new[2]);
			include_once '../view/subject_edit_complete.php';
			unset($_SESSION['subject_editing']);
			unset($_SESSION['subject_edited']);
		} elseif (isset($_POST['add_submit'])) {
			$errors = array();
			if (empty($_POST["add_name"])) {
				$errors["name"] = "Hãy nhập tên môn học!";
			} else {
				$name = $_POST["add_name"];
			}
			if ($_POST["add_school_year"] == 0) {
				$errors["year"] = "Hãy chọn khóa!";
			} else {
				$school_year = "Năm " . $_POST["add_school_year"];
			}
			if (isset($name, $school_year)) {
				if (check($name, $school_year)) {
					$errors["duplicate"] = "Môn học đã tồn tại!";
				}
			}
			$description = $_POST["add_description"];
			if (count($errors) > 0) {
				include '../view/subject_add_input.php';
			} else {
				$_SESSION['subject_adding'] = array($name, $description, $school_year);
				include '../view/subject_add_confirm.php';
			}
			unset($_SESSION['add_subject']);
		} elseif (isset($_POST['add_confirm'])) {
			$subject = $_SESSION['subject_adding'];
			addSubject($subject[0], $subject[1], $subject[2]);
			include '../view/subject_add_complete.php';
			unset($_SESSION['subject_adding']);
		} else {
			for ($i = 0; $i < $count; $i++) {
				$subject = $subjects[$i];
				if (isset($_POST["delete_" . $i . ""])) {
					$_SESSION['subject_deleting'] = $subject;
					include_once "../view/subject_delete_confirm.php";
				} elseif (isset($_POST["edit_" . $i . ""])) {
					$_SESSION['subject_editing'] = $subject;
					include_once "../view/subject_edit_input.php";
				}
			}
		}
	} elseif (isset($_SESSION['add_subject'])) {
		include '../view/subject_add_input.php';
	} else {
		include '../view/subject_search.php';
	}
?>

