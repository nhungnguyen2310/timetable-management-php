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

	require_once '../model/teacher_model.php';

	$data = getTeachers();
	$count = $data[0];
	$teachers = $data[1];
	$subjects = getSubjects();

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["search"])) {
			$keyword = $_POST['keyword'];
			if ($_POST['subject_id'] != 0) {
				$subject_id = $subjects[$_POST['subject_id']];
				$data = search($keyword, $subject_id);
			} else {
				$data = search($keyword);
			}
			$count = $data[0];
			$teachers = $data[1];
			include_once '../view/teacher_search.php';
		} elseif (isset($_POST["back"])) {
			if (isset($_SESSION['add_teacher'])) {
				unset($_SESSION['add_teacher']);
			}
			include_once '../view/teacher_search.php';
		} elseif (isset($_POST["home"])) {
			if (isset($_SESSION['add_teacher'])) {
				unset($_SESSION['add_teacher']);
			}
			redirect("../../home.php");
		} elseif (isset($_POST["delete_confirm"])) {
			$teacher = $_SESSION['teacher_deleting'];
			$id = $teacher['id'];
			deleteTeacher($id);
			include_once '../view/teacher_delete_complete.php';
			unset($_SESSION['teacher_deleting']);
		} elseif (isset($_POST["edit_submit"])) {
			$error = "";
			$teacher = $_SESSION['teacher_editing'];
			if (empty($_POST["new_name"])) {
				$new_name = $teacher["name"];
			} else {
				$new_name = $_POST["new_name"];
			}
			if (empty($_POST["new_subject_id"])) {
				$new_subject_id = $teacher["subject_id"];
			} else {
				$new_subject_id = getSubjectID($subjects[$_POST["new_subject_id"]]);
			}
			if (empty($_POST["new_degree"])) {
				$new_degree = $teacher["degree"];
			} else {
				$new_degree = $_POST["new_degree"];
			}
			if ($_FILES["new_avatar"]['size'] == 0) {
				$new_avatar = $teacher["avatar"];
			} else {
				$extension = explode(".", $_FILES["new_avatar"]["name"])[1];
				$new_avatar = $new_name . "." . $extension;
			}
			$new_description = $_POST["new_description"];
			if (check($new_name, $new_description, $new_subject_id, $new_degree)) {
				if (!($_FILES["new_avatar"]['size'] != 0 && $new_name == $teacher["name"] && $new_subject_id == $teacher["subject_id"] && $new_degree == $teacher["degree"] && $new_description == $teacher["description"])) {
					console_log("Yes");
					$error = "Giáo viên đã tồn tại!";
				}
			}
			if (!empty($error)) {
				$teacher = $_SESSION['teacher_editing'];
				include '../view/teacher_edit_input.php';
			} else {
				if ($new_avatar != $teacher["avatar"]) {
					saveAvatar("new_avatar", $teacher["avatar"], $new_avatar);
				}
				$_SESSION['teacher_edited'] = array($new_name, $new_avatar, $new_description, $new_subject_id, $new_degree);
				include_once '../view/teacher_edit_confirm.php';
			}
		} elseif (isset($_POST["edit_confirm"])) {
			$teacher = $_SESSION['teacher_editing'];
			$new = $_SESSION['teacher_edited'];
			editTeacher($teacher["id"], $new[0], $new[1], $new[2], $new[3], $new[4]);
			include_once '../view/teacher_edit_complete.php';
			unset($_SESSION['teacher_editing']);
			unset($_SESSION['teacher_edited']);
		} elseif (isset($_POST['add_submit'])) {
			$errors = array();
			$name = "";
			$subject_id = "";
			$degree = "";
			if (empty($_POST["add_name"])) {
				$errors["name"] = "Hãy nhập tên giáo viên!";
			} else {
				$name = $_POST["add_name"];
			}
			if (empty($_POST["add_subject_id"])) {
				$errors["subject_id"] = "Hãy chọn chuyên ngành!";
			} else {
				$subject_id = getSubjectID($subjects[$_POST["add_subject_id"]]);
			}
			if (empty($_POST["add_degree"])) {
				$errors["degree"] = "Hãy nhập học vị!";
			} else {
				$degree = $_POST["add_degree"];
			}
			$description = $_POST["add_description"];
			if ($_FILES["add_avatar"]['size'] == 0) {
				$avatar = "temp.jpg";
			} else {
				$avatar = $name . "." . explode(".", $_FILES["add_avatar"]["name"])[1];
				saveAvatar("add_avatar", "temp.jpg", $avatar);
			}
			if (check($name, $avatar, $description, $subject_id, $degree)) {
				$errors["duplicate"] = "Giáo viên đã tồn tại!";
			}
			if (count($errors) > 0) {
				include '../view/teacher_add_input.php';
			} else {
				$_SESSION['teacher_adding'] = array($name, $avatar, $description, $subject_id, $degree);
				include '../view/teacher_add_confirm.php';
				unset($_SESSION['add_teacher']);
			}
		} elseif (isset($_POST['add_confirm'])) {
			$teacher = $_SESSION['teacher_adding'];
			addTeacher($teacher[0], $teacher[1], $teacher[2], $teacher[3], $teacher[4]);
			include '../view/teacher_add_complete.php';
			unset($_SESSION['teacher_adding']);
		} else {
			for ($i = 0; $i < $count; $i++) {
				$teacher = $teachers[$i];
				if (isset($_POST["delete_" . $i . ""])) {
					$_SESSION['teacher_deleting'] = $teacher;
					include_once "../view/teacher_delete_confirm.php";
				} elseif (isset($_POST["edit_" . $i . ""])) {
					$_SESSION['teacher_editing'] = $teacher;
					include_once "../view/teacher_edit_input.php";
				}
			}
		}
	} elseif (isset($_SESSION['add_teacher'])) {
		include '../view/teacher_add_input.php';
	} else {
		include '../view/teacher_search.php';
	}
?>

