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

	require_once '../model/schedule_model.php';

	$data = getSchedules();
	$count = $data[0];
	$schedules = $data[1];
	$subjects = getSubjects("");
	$teachers = getTeachers("");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["search"])) {
			$keyword = $_POST['keyword'];
			$school_year = "";
			$subject = "";
			if ($_POST['school_year'] != 0) {
				$school_year = "Năm " . $_POST['school_year'];
			}
			if ($_POST['subject'] != 0) {
				$subject = $subjects[$_POST['subject']];
			}
			$data = search($keyword, $school_year, $subject);
			$count = $data[0];
			$schedules = $data[1];
			include_once '../view/schedule_search.php';
		} elseif (isset($_POST["back"])) {
			if (isset($_SESSION['add_schedule'])) {
				unset($_SESSION['add_schedule']);
			}
			if (isset($_SESSION['edit_schedule'])) {
				unset($_SESSION['edit_schedule']);
			}
			echo "<script>self.location = 'schedule.php';</script>";
			include_once '../view/schedule_search.php';
		} elseif (isset($_POST["home"])) {
			if (isset($_SESSION['add_schedule'])) {
				unset($_SESSION['add_schedule']);
			}
			if (isset($_SESSION['edit_schedule'])) {
				unset($_SESSION['edit_schedule']);
			}
			echo "<script>self.location = 'schedule.php';</script>";
			redirect("../../home.php");
		} elseif (isset($_POST["delete_confirm"])) {
			$schedule = $_SESSION['schedule_deleting'];
			$id = $schedule['id'];
			deleteSchedule($id);
			include_once '../view/schedule_delete_complete.php';
			unset($_SESSION['schedule_deleting']);
		} elseif (isset($_POST["edit_submit"])) {
			$error = "";
			$schedule = $_SESSION['schedule_editing'];
			if (empty($_POST["new_school_year"])) {
				$new_school_year = getSchoolYear($schedule["subject_id"]);
			} else {
				$new_school_year = "Năm " . $_POST["new_school_year"];
			}
			if (empty($_POST["new_subject"])) {
				$new_subject_id = $schedule["subject_id"];
			} else {
				$_subjects = getSubjects($new_school_year);
				$new_subject_id = getSubjectID($_subjects[$_POST["new_subject"]], $new_school_year);
			}
			if (empty($_POST["new_teacher"])) {
				$new_teacher_id = $schedule["teacher_id"];
			} else {
				$_teachers = getTeachers($new_subject_id);
				$new_teacher_id = getTeacherID($_teachers[$_POST["new_teacher"]]);
			}
			if (empty($_POST["new_weekday"])) {
				$new_weekday = $schedule["weekday"];
			} else {
				$new_weekday = "Thứ " . $_POST["new_weekday"]+1;
			}
			$new_lesson = "";
			for ($i = 1; $i <= 10; $i++) {
				if (isset($_POST["new_lesson_" . $i])) {
					$new_lesson = $new_lesson . $i . ", ";
				}
			}
			$new_lesson = substr($new_lesson, 0, -2);
			if (empty($new_lesson)) {
				$new_lesson = $schedule["lesson"];
			}
			$new_notes = $_POST["new_notes"];
			if (check($new_teacher_id, $new_weekday, $new_lesson, $new_notes)) {
				$error = "Lớp học đã tồn tại!";
			}
			if (!empty($error)) {
				$_SESSION["_edit_schedule"] = true;
				$schedule = $_SESSION['schedule_editing'];
				include '../view/schedule_edit_input.php';
			} else {
				$_SESSION['schedule_edited'] = array($new_teacher_id, $new_weekday, $new_lesson, $new_notes);
				include_once '../view/schedule_edit_confirm.php';
			}
		} elseif (isset($_POST["edit_confirm"])) {
			$schedule = $_SESSION['schedule_editing'];
			$new = $_SESSION['schedule_edited'];
			editSchedule($schedule["id"], $new[0], $new[1], $new[2], $new[3]);
			include_once '../view/schedule_edit_complete.php';
			unset($_SESSION['schedule_editing']);
			unset($_SESSION['schedule_edited']);
			unset($_SESSION['edit_schedule']);
		} elseif (isset($_POST['add_submit'])) {
			$errors = array();
			$school_year = "";
			$subject_id = "";
			$teacher_id = "";
			$weekday = "";
			$lesson = "";
			if (empty($_POST["add_school_year"])) {
				$errors["1"] = "Hãy chọn năm học!";
			} else {
				$school_year = "Năm " . $_POST["add_school_year"];
			}
			if (empty($_POST["add_subject"])) {
				$errors["2"] = "Hãy chọn môn học!";
			} else {
				$_subjects = getSubjects($school_year);
				$subject_id = getSubjectID($_subjects[$_POST["add_subject"]], $school_year);
			}
			if (empty($_POST["add_teacher"])) {
				$errors["3"] = "Hãy chọn giáo viên!";
			} else {
				$_teachers = getTeachers($subject_id);
				$teacher_id = getTeacherID($_teachers[$_POST["add_teacher"]]);
			}
			if (empty($_POST["add_weekday"])) {
				$errors["4"] = "Hãy chọn ngày học!";
			} else {
				$weekday = "Thứ " . $_POST["add_weekday"]+1;
			}
			for ($i = 1; $i <= 10; $i++) {
				if (isset($_POST["add_lesson_" . $i])) {
					$lesson = $lesson . $i . ", ";
				}
			}
			$lesson = substr($lesson, 0, -2);
			if ($lesson == "") {
				$errors["5"] = "Hãy chọn tiết!";
			}
			$notes = $_POST["add_notes"];
			if (check($teacher_id, $weekday, $lesson, $notes)) {
				$errors["duplicate"] = "Lớp học đã tồn tại!";
			}
			if (count($errors) > 0) {
				include '../view/schedule_add_input.php';
			} else {
				$_SESSION['schedule_adding'] = array($teacher_id, $weekday, $lesson, $notes);
				include '../view/schedule_add_confirm.php';
				unset($_SESSION['add_schedule']);
			}
		} elseif (isset($_POST['add_confirm'])) {
			$schedule = $_SESSION['schedule_adding'];
			addSchedule($schedule[0], $schedule[1], $schedule[2], $schedule[3]);
			include '../view/schedule_add_complete.php';
			unset($_SESSION['schedule_adding']);
		} else {
			for ($i = 0; $i < $count; $i++) {
				$schedule = $schedules[$i];
				if (isset($_POST["delete_" . $i . ""])) {
					$_SESSION['schedule_deleting'] = $schedule;
					include "../view/schedule_delete_confirm.php";
				} elseif (isset($_POST["edit_" . $i . ""])) {
					$_SESSION['schedule_editing'] = $schedule;
					$_SESSION['edit_schedule'] = true;
					$_SESSION['_edit_schedule'] = true;
					include "../view/schedule_edit_input.php";
				}
			}
		}
	} elseif (isset($_SESSION['add_schedule'])) {
		include '../view/schedule_add_input.php';
	} elseif (isset($_SESSION["edit_schedule"])) {
		$schedule = $_SESSION['schedule_editing'];
		include "../view/schedule_edit_input.php";
	} else {
		include '../view/schedule_search.php';
	}
?>

