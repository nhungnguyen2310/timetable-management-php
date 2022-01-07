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
	$degrees = array("--Chọn học vị--", "Cử nhân", "Thạc sĩ", "Tiến sĩ", "Phó giáo sư", "Giáo sư");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["back"])) {
			if (isset($_SESSION['add_teacher'])) {
				unset($_SESSION['add_teacher']);
			}
			clean();
			include_once '../view/teacher_search.php';
		} elseif (isset($_POST["home"])) {
			if (isset($_SESSION['add_teacher'])) {
				unset($_SESSION['add_teacher']);
			}
			clean();
			redirect("../../home.php");
		}  elseif (isset($_POST["back_edit"])) {
			$teacher = $_SESSION['teacher_edited'];
			$name = $teacher["name"];
			$subject = getSubjectName($teacher["subject_id"]);
			$degree = $teacher["degree"];
			$avatar = "../tmp/" . $teacher["avatar"];
			$description = $teacher["description"];
			include '../view/teacher_edit_input.php';
		} elseif (isset($_POST["edit_submit"])) {
			$errors = array();
			$teacher = $_SESSION['teacher_editing'];
			$avatar = $teacher["avatar"];
			$subject = getSubjectName($teacher["subject_id"]);
			if (empty($_POST["new_name"])) {
				$errors["name"] = "Hãy nhập tên giáo viên!";
				$name = "";
			} else {
				$name = format($_POST["new_name"]);
			}
			if (empty($_POST["new_subject_id"])) {
				$errors["subject"] = "Hãy chọn chuyên ngành!";
				$subject = 0;
				$subject_id = -1;
			} else {
				$subject_id = getSubjectID($subjects[$_POST["new_subject_id"]]);
			}
			if (empty($_POST["new_degree"])) {
				$errors["degree"] = "Hãy chọn học vị!";
				$degree = "";
			} else {
				$degree = $degrees[$_POST["new_degree"]];
			}
			if ($_FILES["new_avatar"]['size'] != 0) {
				$extension = explode(".", $_FILES["new_avatar"]["name"])[1];
				$avatar = $name . "." . $extension;
				$_SESSION["teacher_avatar_edited"] = $avatar;
			}
			if (empty($_POST["new_description"])) {
				$errors["description"] = "Hãy nhập mô tả chi tiết!";
				$description = "";
			} else {
				$description = format($_POST["new_description"]);
			}
			if (check($name, $description, $subject_id, $degree) && !isset($_SESSION["teacher_avatar_edited"])) {
				$errors["duplicate"] = "Giáo viên đã tồn tại!";
			}
			if (count($errors) > 0) {
				include '../view/teacher_edit_input.php';
			} else {
				if (!isset($_SESSION["teacher_avatar_edited"])) {
					copy("../../web/avatar/teacher/" . $avatar, "../../web/avatar/tmp/" . $avatar);
				} else {
					$avatar = $_SESSION["teacher_avatar_edited"];
					if ($_FILES["new_avatar"]['size'] != 0) {
						saveTempAvatar("new_avatar", $avatar);
					}
				}
				$_SESSION['teacher_edited'] = array("name" => $name, "avatar" => $avatar, "description" => $description, "subject_id" => $subject_id, "degree" => $degree);
				include_once '../view/teacher_edit_confirm.php';
			}
		} elseif (isset($_POST["edit_confirm"])) {
			$teacher = $_SESSION['teacher_editing'];
			$edited = $_SESSION['teacher_edited'];
			saveAvatar($teacher["avatar"], $edited["avatar"]);
			editTeacher($teacher["id"], $edited["name"], $edited["avatar"], $edited["description"], $edited["subject_id"], $edited["degree"]);
			include_once '../view/teacher_edit_complete.php';
			unset($_SESSION["teacher_avatar_edited"]);
			unset($_SESSION['teacher_editing']);
			unset($_SESSION['teacher_edited']);
		} elseif (isset($_POST["back_add"])) {
			$teacher = $_SESSION['teacher_adding'];
			$name = $teacher["name"];
			$subject_id = $teacher["subject_id"];
			$degree = $teacher["degree"];
			$description = $teacher["description"];
			$avatar = $teacher["avatar"];
			include '../view/teacher_add_input.php';
		} elseif (isset($_POST['add_submit'])) {
			$errors = array();
			if (empty($_POST["add_name"])) {
				$errors["name"] = "Hãy nhập tên giáo viên!";
				$name = "";
			} else {
				$name = format($_POST["add_name"]);
			}
			if (empty($_POST["add_subject_id"])) {
				$errors["subject_id"] = "Hãy chọn chuyên ngành!";
				$subject_id = -1;
			} else {
				$subject_id = getSubjectID($subjects[$_POST["add_subject_id"]]);
			}
			if (empty($_POST["add_degree"])) {
				$errors["degree"] = "Hãy chọn học vị!";
				$degree = "";
			} else {
				$degree = $degrees[$_POST["add_degree"]];
			}
			if (empty($_POST["add_description"])) {
				$errors["description"] = "Hãy nhập mô tả chi tiết!";
				$description = "";
			} else {
				$description = format($_POST["add_description"]);
			}
			if ($_FILES["add_avatar"]['size'] != 0) {
				$_SESSION["teacher_avatar_adding"] = true;
				$avatar = $name . "." . explode(".", $_FILES["add_avatar"]["name"])[1];
				saveTempAvatar("add_avatar", $avatar);
			} elseif (!isset($_SESSION["teacher_avatar_adding"])) {
				$errors["avatar"] = "Hãy chọn ảnh đại diện!";
				$avatar = "";
			}
			if (check($name, $avatar, $description, $subject_id, $degree)) {
				$errors["duplicate"] = "Giáo viên đã tồn tại!";
			}
			if (count($errors) > 0) {
				include '../view/teacher_add_input.php';
			} else {
				$_SESSION['teacher_adding'] = array("name" => $name, "avatar" => $avatar, "description" => $description, "subject_id" => $subject_id, "degree" => $degree);
				include '../view/teacher_add_confirm.php';
				unset($_SESSION['add_teacher']);
			}
		} elseif (isset($_POST['add_confirm'])) {
			$teacher = $_SESSION['teacher_adding'];
			saveAvatar("temp.jpg", $teacher["avatar"]);
			addTeacher($teacher["name"], $teacher["avatar"], $teacher["description"], $teacher["subject_id"], $teacher["degree"]);
			include '../view/teacher_add_complete.php';
			unset($_SESSION['teacher_adding']);
			unset($_SESSION['teacher_avatar_adding']);
		} else {
			for ($i = 0; $i < $count; $i++) {
				$teacher = $teachers[$i];
				if (isset($_POST["delete_" . $i . ""])) {
					deleteTeacher($teacher["id"]);
					header("Refresh:0");
				} elseif (isset($_POST["edit_" . $i . ""])) {
					$_SESSION['teacher_editing'] = $teacher;
					$name = $teacher["name"];
					$subject = getSubjectName($teacher["subject_id"]);
					$degree = $teacher["degree"];
					$avatar = $teacher["avatar"];
					$description = $teacher["description"];
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

