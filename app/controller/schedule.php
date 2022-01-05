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
	$subjects = getSubjects();
	$teachers = getTeachers();

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["back"])) {
			if (isset($_SESSION['add_schedule'])) {
				unset($_SESSION['add_schedule']);
			}
			if (isset($_SESSION['edit_schedule'])) {
				unset($_SESSION['edit_schedule']);
			}
			echo "<script>self.location = 'schedule.php';</script>";
			clean();
			include_once '../view/schedule_search.php';
		} elseif (isset($_POST["home"])) {
			if (isset($_SESSION['add_schedule'])) {
				unset($_SESSION['add_schedule']);
			}
			if (isset($_SESSION['edit_schedule'])) {
				unset($_SESSION['edit_schedule']);
			}
			echo "<script>self.location = 'schedule.php';</script>";
			clean();
			redirect("../../home.php");
		} elseif (isset($_POST["back_edit"])) {
			$_SESSION["_edit_schedule"] = true;
			$schedule = $_SESSION["schedule_edited"];
			include '../view/schedule_edit_input.php';
		} elseif (isset($_POST["edit_submit"])) {
			$errors = array();
			$schedule = $_SESSION['schedule_editing'];
			if (empty($_POST["new_school_year"])) {
				$errors["school_year"] = "Hãy chọn năm học!";
				$school_year = "";
			} else {
				$school_year = "Năm " . $_POST["new_school_year"];
			}
			if (empty($_POST["new_subject"])) {
				$errors["subject"] = "Hãy chọn môn học";
				$subject_id = -1;
			} else {
				$_subjects = getSubjects($school_year);
				$subject_id = getSubjectID($_subjects[$_POST["new_subject"]], $school_year);
			}
			if (empty($_POST["new_teacher"])) {
				$errors["teacher"] = "Hãy chọn giáo viên!";
				$teacher_id = -1;
			} else {
				$_teachers = getTeachers($subject_id);
				$teacher_id = getTeacherID($_teachers[$_POST["new_teacher"]]);
			}
			$schedule["teacher_id"] = $teacher_id;
			if (empty($_POST["new_weekday"])) {
				$errors["weekday"] = "Hãy chọn ngày học!";
				$weekday = "";
			} else {
				$weekday = "Thứ " . $_POST["new_weekday"]+1;
			}
			$schedule["weekday"] = $weekday;
			$lesson = "";
			for ($i = 1; $i <= 10; $i++) {
				if (isset($_POST["new_lesson_" . $i])) {
					$lesson = $lesson . $i . ", ";
				}
			}
			$lesson = substr($lesson, 0, -2);
			if (empty($lesson)) {
				$errors["lesson"] = "Hãy chọn tiết học!";
			}
			$schedule["lesson"] = $lesson;
			if (empty($_POST["new_notes"])) {
				$errors["notes"] = "Hãy nhập ghi chú!";
				$notes = "";
			} else {
				$notes = format($_POST["new_notes"]);
			}
			$schedule["notes"] = $notes;
			if (check($teacher_id, $weekday, $lesson, $notes)) {
				$errors["duplicate"] = "Lớp học đã tồn tại!";
			}
			if (count($errors) > 0) {
				$_SESSION["_edit_schedule"] = true;
				include '../view/schedule_edit_input.php';
			} else {
				$_SESSION['schedule_edited'] = array("teacher_id" => $teacher_id, "weekday" => $weekday, "lesson" => $lesson, "notes" => $notes);
				include_once '../view/schedule_edit_confirm.php';
			}
		} elseif (isset($_POST["edit_confirm"])) {
			$schedule = $_SESSION['schedule_editing'];
			$edited = $_SESSION['schedule_edited'];
			editSchedule($schedule["id"], $edited["teacher_id"], $edited["weekday"], $edited["lesson"], $edited["notes"]);
			include_once '../view/schedule_edit_complete.php';
			unset($_SESSION['schedule_editing']);
			unset($_SESSION['schedule_edited']);
			unset($_SESSION['edit_schedule']);
		} elseif (isset($_POST["back_add"])) {
			$schedule = $_SESSION["schedule_adding"];
			$school_year = $schedule["school_year"];
			$subject_id = $schedule["subject_id"];
			$teacher_id = $schedule["teacher_id"];
			$weekday = $schedule["weekday"];
			$lesson = $schedule["lesson"];
			$notes = $schedule["notes"];
			include '../view/schedule_edit_input.php';
		} elseif (isset($_POST['add_submit'])) {
			$errors = array();
			if (empty($_POST["add_school_year"])) {
				$errors["school_year"] = "Hãy chọn năm học!";
				$school_year = "";
			} else {
				$school_year = "Năm " . $_POST["add_school_year"];
			}
			if (empty($_POST["add_subject"])) {
				$errors["subject"] = "Hãy chọn môn học!";
				$subject_id = "";
			} else {
				$_subjects = getSubjects($school_year);
				$subject_id = getSubjectID($_subjects[$_POST["add_subject"]], $school_year);
			}
			if (empty($_POST["add_teacher"])) {
				$errors["teacher"] = "Hãy chọn giáo viên!";
				$teacher_id = "";
			} else {
				$_teachers = getTeachers($subject_id);
				$teacher_id = getTeacherID($_teachers[$_POST["add_teacher"]]);
			}
			if (empty($_POST["add_weekday"])) {
				$errors["weekday"] = "Hãy chọn ngày học!";
				$weekday = "";
			} else {
				$weekday = "Thứ " . $_POST["add_weekday"]+1;
			}
			$lesson = "";
			for ($i = 1; $i <= 10; $i++) {
				if (isset($_POST["add_lesson_" . $i])) {
					$lesson = $lesson . $i . ", ";
				}
			}
			$lesson = substr($lesson, 0, -2);
			if ($lesson == "") {
				$errors["lesson"] = "Hãy chọn tiết!";
			}
			if (empty($_POST["add_notes"])) {
				$errors["notes"] = "Hãy nhập ghi chú!";
				$notes = "";
			} else {
				$notes = format($_POST["add_notes"]);
			}
			if (check($teacher_id, $weekday, $lesson, $notes)) {
				$errors["duplicate"] = "Lớp học đã tồn tại!";
			}
			if (count($errors) > 0) {
				include '../view/schedule_add_input.php';
			} else {
				$_SESSION['schedule_adding'] = array("teacher_id" => $teacher_id, "weekday" => $weekday, "lesson" => $lesson, "notes" => $notes, "school_year" => $school_year, "subject_id" => $subject_id);
				include '../view/schedule_add_confirm.php';
				unset($_SESSION['add_schedule']);
			}
		} elseif (isset($_POST['add_confirm'])) {
			$schedule = $_SESSION['schedule_adding'];
			addSchedule($schedule["teacher_id"], $schedule["weekday"], $schedule["lesson"], $schedule["notes"]);
			include '../view/schedule_add_complete.php';
			unset($_SESSION['schedule_adding']);
		} else {
			for ($i = 0; $i < $count; $i++) {
				$schedule = $schedules[$i];
				if (isset($_POST["delete_" . $i . ""])) {
					deleteSchedule($schedule["id"]);
					header("Refresh:0");
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

